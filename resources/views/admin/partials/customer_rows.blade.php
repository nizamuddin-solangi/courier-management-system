@forelse($customers as $customer)
<tr>
    <td class="text-white font-bold">{{ $customer->name }}</td>
    <td><i class="bi bi-telephone text-[#45A29E] mr-2"></i>{{ $customer->phone }}</td>
    <td>{{ $customer->city }}</td>
    <td class="opacity-70 text-xs">{{ \Illuminate\Support\Str::limit($customer->address, 60) }}</td>
    <td>
        <div class="flex gap-2">
            <a href="{{ route('admin.customer.edit', $customer->id) }}" class="p-2 rounded-lg bg-blue-500/10 text-blue-400 hover:bg-blue-500/20 transition-colors">
                <i class="bi bi-pencil-square"></i>
            </a>
            <a href="{{ route('admin.customer.delete', $customer->id) }}" onclick="return confirm('Securely delete this customer record?')" class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition-colors">
                <i class="bi bi-trash"></i>
            </a>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center py-10 opacity-50">
        <i class="bi bi-folder-x text-4xl mb-3 block"></i>
        No customer records found matching your query.
    </td>
</tr>
@endforelse
<tr>
    <td colspan="5" class="p-0">
        <div class="p-6 border-t border-white/5">
            {{ $customers->links() }}
        </div>
    </td>
</tr>
