<?php

namespace App\Providers;

use App\Contracts\EventPusher;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\VideoController;
use App\Utilities\RedisEventPusher;
use App\Utilities\ReportAggregator;
use App\Utilities\Transistor;
use App\Utilities\PodcastParser;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //$service = new Transistor(new PodcastParser);
        //
        //$this->app->instance(Transistor::class, $service);

        //$this->app->bind(Transistor::class, function ($app) {
        //    return new Transistor($app->make(PodcastParser::class));
        //});

        //$this->app->bind(EventPusher::class,RedisEventPusher::class);
        $this->app->when(PhotoController::class)
            ->needs(Filesystem::class)
            ->give(function () {
                return Storage::disk('local');
            });

        $this->app->when([VideoController::class, UploadController::class])
            ->needs(Filesystem::class)
            ->give(function () {
                return Storage::disk('s3');
            });

        $this->app->when(ReportAggregator::class)
            ->needs('$reports')
            ->giveTagged('reports');
        //
        //$this->app->when(ReportAggregator::class)
        //    ->needs('$timezone')
        //    ->giveConfig('app.timezone');

        $value = 18;
        $this->app->when('App\Http\Controllers\PhotoController')
            ->needs('$int')
            ->give($value);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
