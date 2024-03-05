<?php

namespace App\Providers;

use App\Models\admin\Setting;
use Illuminate\Support\ServiceProvider;

class DataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer([
            'administrator.layouts.main',
            'administrator.authentication.main',
            'administrator.authentication.login',
            'administrator.authentication.logo',
            'administrator.authentication.footer',
            'administrator.authentication.header',
            'administrator.profile.reset_password.template',
            'administrator.logs.export'
        ], function ($view) {
            $settings = Setting::get()->toArray();
        
            $settings = array_column($settings, 'value', 'name');
            $view->with('settings', $settings);
        });

        view()->composer([
            'frontpage.home.part.by_category',
            'frontpage.home.part.store',
            'frontpage.home.part.checkout_new_arrivals',
            'frontpage.home.part.best_deals',
            'frontpage.home.part.best_sellers'
        ], function ($view) {
            $settings = Setting::get()->toArray();
        
            $settings = array_column($settings, 'value', 'name');
            $view->with('settings', $settings);
        });
    }
}
