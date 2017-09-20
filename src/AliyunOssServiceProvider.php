<?php

namespace Chenhua\AliyunOss;

use Illuminate\Support\ServiceProvider;

class AliyunOssServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/aliyun.php' => config_path('aliyun.php'),
        ], 'aliyun.oss');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind("aliyun-oss", function(){
            return new AliyunOss();
        });
    }
}
