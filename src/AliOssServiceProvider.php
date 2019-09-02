<?php

namespace Jacobcyl\AliOSS;

use Jacobcyl\AliOSS\Plugins\GetDownloadUrl;
use Jacobcyl\AliOSS\Plugins\GetPreviewUrl;
use Jacobcyl\AliOSS\Plugins\GetPutUrl;
use Jacobcyl\AliOSS\Plugins\GetStsAuth;
use Jacobcyl\AliOSS\Plugins\PutFile;
use Jacobcyl\AliOSS\Plugins\PutRemoteFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use OSS\OssClient;

class AliOssServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //发布配置文件
        /*
        if (function_exists('config_path')) {
            $this->publishes([
                __DIR__ . '/config/config.php' => config_path('alioss.php'),
            ], 'config');
        }
        */

        Storage::extend('oss', function ($app, $config) {

            $adapter = new AliOssAdapter($config);

            //Log::debug($client);
            $filesystem = new Filesystem($adapter);

            $filesystem->addPlugin(new PutFile());
            $filesystem->addPlugin(new PutRemoteFile());
            $filesystem->addPlugin(new GetDownloadUrl());
            $filesystem->addPlugin(new GetStsAuth());

            //$filesystem->addPlugin(new CallBack());
            return $filesystem;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }

}
