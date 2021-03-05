<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TargetRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \packages\Domain\ITargetRepository::class,
            \packages\Infrastructure\TargetRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
