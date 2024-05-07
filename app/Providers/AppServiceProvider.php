<?php

namespace App\Providers;

use App\Models\SettingModel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        $systemSettings = SettingModel::getSetting(); // Lấy các thiết lập từ model

        // Lưu các thiết lập vào biến toàn cục
        config(['app.system_settings' => $systemSettings]);
    }
}
