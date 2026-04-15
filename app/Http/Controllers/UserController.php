<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserController extends Controller
{
    public function index(){
        return view("user.index");
    }

    public function track(){
        return view('user.track');
    }

    public function track_lookup(Request $request): JsonResponse
    {
        $trackingNumber = trim((string) $request->query('tracking_number', ''));
        if ($trackingNumber === '') {
            return response()->json([
                'ok' => false,
                'message' => 'Tracking number is required.',
            ], 422);
        }

        $courier = Courier::query()
            ->with(['agent:id,name'])
            ->where('tracking_number', $trackingNumber)
            ->first();

        if (!$courier) {
            return response()->json([
                'ok' => false,
                'message' => 'Shipment not found.',
            ], 404);
        }

        $status = (string) $courier->status;
        $createdAt = optional($courier->created_at)->toISOString();
        $updatedAt = optional($courier->updated_at)->toISOString();
        $deliveryDate = $courier->delivery_date ? (string) $courier->delivery_date : null;
        $deliveryTime = $courier->delivery_time ? (string) $courier->delivery_time : null;

        // We don't have a dedicated status history table yet, so generate a sensible timeline from current status.
        $timeline = [];
        $timeline[] = [
            'title' => 'Shipment Booked',
            'location' => $courier->from_city,
            'at' => $createdAt,
            'meta' => 'Shipment created',
        ];

        if (in_array($status, ['in_transit', 'delivered'], true)) {
            $timeline[] = [
                'title' => 'In Transit',
                'location' => 'On Route',
                'at' => $updatedAt ?: $createdAt,
                'meta' => 'Shipment dispatched',
            ];
        }

        if ($status === 'delivered') {
            $timeline[] = [
                'title' => 'Delivered',
                'location' => $courier->to_city,
                'at' => $updatedAt ?: $createdAt,
                'meta' => 'Shipment delivered',
            ];
        }

        if ($status === 'cancelled') {
            $timeline[] = [
                'title' => 'Cancelled',
                'location' => $courier->from_city,
                'at' => $updatedAt ?: $createdAt,
                'meta' => 'Shipment cancelled',
            ];
        }

        return response()->json([
            'ok' => true,
            'courier' => [
                'id' => $courier->id,
                'tracking_number' => $courier->tracking_number,
                'agent' => $courier->agent ? [
                    'id' => $courier->agent->id,
                    'name' => $courier->agent->name,
                ] : null,
                'sender_name' => $courier->sender_name,
                'sender_phone' => $courier->sender_phone,
                'sender_address' => $courier->sender_address,
                'receiver_name' => $courier->receiver_name,
                'receiver_phone' => $courier->receiver_phone,
                'receiver_address' => $courier->receiver_address,
                'from_city' => $courier->from_city,
                'to_city' => $courier->to_city,
                'delivery_date' => $deliveryDate,
                'delivery_time' => $deliveryTime,
                'parcel_type' => $courier->parcel_type,
                'weight' => $courier->weight,
                'price' => $courier->price,
                'status' => $status,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ],
            'timeline' => $timeline,
        ]);
    }

    public function track_download(Request $request): StreamedResponse|JsonResponse
    {
        $trackingNumber = trim((string) $request->query('tracking_number', ''));
        if ($trackingNumber === '') {
            return response()->json([
                'ok' => false,
                'message' => 'Tracking number is required.',
            ], 422);
        }

        $courier = Courier::query()
            ->with(['agent:id,name'])
            ->where('tracking_number', $trackingNumber)
            ->first();

        if (!$courier) {
            return response()->json([
                'ok' => false,
                'message' => 'Shipment not found.',
            ], 404);
        }

        $filename = "shipment_{$courier->tracking_number}_" . date('Y-m-d_H-i') . ".csv";
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $columns = [
            'Tracking ID',
            'Status',
            'From City',
            'To City',
            'Sender Name',
            'Sender Phone',
            'Sender Address',
            'Receiver Name',
            'Receiver Phone',
            'Receiver Address',
            'Parcel Type',
            'Weight',
            'Price',
            'Delivery Date',
            'Delivery Time',
            'Assigned Agent',
            'Booked At',
            'Last Updated',
        ];

        $callback = function () use ($courier, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $row = [
                $courier->tracking_number,
                str_replace("_", " ", strtoupper((string) $courier->status)),
                $courier->from_city,
                $courier->to_city,
                $courier->sender_name,
                $courier->sender_phone,
                $courier->sender_address,
                $courier->receiver_name,
                $courier->receiver_phone,
                $courier->receiver_address,
                $courier->parcel_type,
                $courier->weight,
                $courier->price,
                $courier->delivery_date ? (string) $courier->delivery_date : '',
                $courier->delivery_time ? (string) $courier->delivery_time : '',
                $courier->agent?->name ?? '',
                $courier->created_at?->format('Y-m-d H:i:s') ?? '',
                $courier->updated_at?->format('Y-m-d H:i:s') ?? '',
            ];
            fputcsv($file, $row);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function login(){
        return view('user.login');
    }

    public function profile()
    {
        $userId = Session::get('user_id');
        $user = User::findOrFail($userId);
        return view('user.profile', compact('user'));
    }

    public function notifications()
    {
        $userId = Session::get('user_id');

        if (!$userId) {
            $notifications = collect();
            $unreadCount = 0;
            return view('user.notifications', compact('notifications', 'unreadCount'));
        }

        $notifications = Notification::query()
            ->where('user_id', $userId)
            ->orderByDesc('id')
            ->limit(100)
            ->get();

        $unreadCount = Notification::query()
            ->where('user_id', $userId)
            ->where('is_read', false)
            ->count();

        return view('user.notifications', compact('notifications', 'unreadCount'));
    }

    public function notifications_mark_read()
    {
        $userId = Session::get('user_id');
        Notification::query()
            ->where('user_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return redirect()->back();
    }

    public function update_profile(Request $request)
    {
        $userId = Session::get('user_id');

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$userId],
            'phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+]+$/', 'unique:users,phone,'.$userId],
            'address' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'name.regex' => 'Name must only contain letters and spaces (e.g., John Doe).',
            'phone.regex' => 'Phone number must only contain digits and + (e.g., +123456789).',
            'image.image' => 'The file must be an image (JPG, PNG, WebP).',
        ]);

        $user = User::findOrFail($userId);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->filled('password')) {
            $user->password = Hash::make((string) $request->password);
        }

        if ($request->hasFile('image')) {
            $dir = public_path('uploads/users');
            File::ensureDirectoryExists($dir);

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $user->image = $filename;
        }

        $user->save();

        // Refresh session header data
        Session::put('user_name', $user->name);
        Session::put('user_email', $user->email);
        Session::put('user_image', $user->image);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function login_submit(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        $isValid = false;
        if ($user) {
            // Support both hashed and plain (for legacy/demo) – same pattern as admin/agent.
            if (preg_match('/^\$2[ayb]\$.{56}$/', (string) $user->password)) {
                $isValid = Hash::check((string) $request->password, (string) $user->password);
            } else {
                $isValid = ((string) $user->password === (string) $request->password);
            }
        }

        if ($user && $isValid) {
            Session::put('user_logged_in', true);
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->name);
            Session::put('user_email', $user->email);
            Session::put('user_image', $user->image);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Signed in successfully.',
                    'redirect' => route('user.index'),
                ]);
            }

            return redirect()->route('user.index');
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials.',
            ], 401);
        }

        return redirect()->back()->with('error', 'Invalid credentials.');
    }

    public function register(){
        return view('user.register');
    }

    public function register_submit(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:100', 'regex:/^[a-zA-Z\s]+$/'],
            'last_name' => ['required', 'string', 'max:100', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+]+$/', 'unique:users,phone'],
            'address' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'first_name.regex' => 'First name must only contain letters and spaces.',
            'last_name.regex' => 'Last name must only contain letters and spaces.',
            'phone.regex' => 'Phone number must only contain digits and +.',
            'image.image' => 'The file must be an image.',
        ]);

        $name = trim($request->first_name . ' ' . $request->last_name);

        $imageName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/users'), $imageName);
        }

        $user = User::create([
            'name' => $name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'image' => $imageName,
            'password' => Hash::make((string) $request->password),
        ]);

        Session::put('user_logged_in', true);
        Session::put('user_id', $user->id);
        Session::put('user_name', $user->name);
        Session::put('user_email', $user->email);
        Session::put('user_image', $user->image);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Account created successfully.',
                'redirect' => route('user.index'),
            ]);
        }

        return redirect()->route('user.index');
    }

    public function logout()
    {
        Session::forget(['user_logged_in', 'user_id', 'user_name', 'user_email', 'user_image']);
        return redirect()->route('user.login');
    }
}

