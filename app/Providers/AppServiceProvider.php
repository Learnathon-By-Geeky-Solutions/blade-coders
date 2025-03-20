<?php

namespace App\Providers;

use AmdadulHaq\Setting\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
        if (Schema::hasTable('settings')) {
            $settings = Setting::all();

            foreach ($settings as $setting) {
                if (Str::startsWith($setting->key, 'app_')) {
                    $key = Str::replaceFirst('_', '.', $setting->key);

                    config()->set($key, $setting->value);
                } else {
                    config()->set('setting.'.$setting->key, $setting->value);
                }
            }
        }
    }
}
