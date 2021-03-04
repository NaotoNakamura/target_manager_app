<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use packages\UseCase\TargetIndexUseCase;
use packages\UseCase\TargetStoreUseCase;
use packages\UseCase\TargetShowUseCase;
use packages\UseCase\TargetUpdateUseCase;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('TargetIndexUseCase', TargetIndexUseCase::class);
        $this->app->bind('TargetStoreUseCase', TargetStoreUseCase::class);
        $this->app->bind('TargetShowUseCase', TargetShowUseCase::class);
        $this->app->bind('TargetUpdateUseCase', TargetUpdateUseCase::class);
        $this->app->bind('TargetDestroyUseCase', TargetDestroyUseCase::class);
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
