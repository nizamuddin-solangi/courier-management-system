<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production (required when behind a reverse proxy like Railway/Render)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            if (\Illuminate\Support\Facades\Session::has('admin_id')) {
                $admin = \App\Models\Admin::find(\Illuminate\Support\Facades\Session::get('admin_id'));
                if (!$admin && \Illuminate\Support\Facades\Session::get('admin_is_demo')) {
                    $admin = (object) ['id' => 999, 'name' => 'Demo Administrator', 'email' => 'admin@demo.com', 'image' => null];
                }
                $view->with('current_admin', $admin);
            }
            if (\Illuminate\Support\Facades\Session::has('agent_id')) {
                $agent = \App\Models\Agent::find(\Illuminate\Support\Facades\Session::get('agent_id'));
                if (!$agent && \Illuminate\Support\Facades\Session::get('agent_is_demo')) {
                    $agent = (object) [
                        'id' => 999, 'name' => 'Demo Agent', 
                        'username' => 'agent_demo', 
                        'branch_name' => 'Demo Branch (Sandbox)',
                        'agent_code' => 'DEMO-999',
                        'email' => 'agent@demo.com',
                        'image' => null
                    ];
                }
                $view->with('current_agent', $agent);
            }
            if (\Illuminate\Support\Facades\Session::has('user_id')) {
                $user = \App\Models\User::find(\Illuminate\Support\Facades\Session::get('user_id'));
                if (!$user && \Illuminate\Support\Facades\Session::get('user_is_demo')) {
                    $user = (object) [
                        'id' => 999, 'name' => 'Demo User', 
                        'email' => 'user@demo.com', 
                        'phone' => '+123456789',
                        'image' => null
                    ];
                }
                $view->with('current_user', $user);
            }
        });
    }
}
