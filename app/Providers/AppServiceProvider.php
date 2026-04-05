<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            if (\Illuminate\Support\Facades\Session::has('admin_id')) {
                $admin = \App\Models\Admin::find(\Illuminate\Support\Facades\Session::get('admin_id'));
                $view->with('current_admin', $admin);
            }
            if (\Illuminate\Support\Facades\Session::has('agent_id')) {
                $agent = \App\Models\Agent::find(\Illuminate\Support\Facades\Session::get('agent_id'));
                $view->with('current_agent', $agent);
            }
        });
    }
}
