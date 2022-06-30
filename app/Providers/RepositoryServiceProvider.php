<?php

namespace App\Providers;

use App\Contracts\AuthContract;
use App\Contracts\LocationContract;
use App\Contracts\OfficeContract;
use App\Repositories\AuthRepository;
use App\Repositories\LocationRepository;
use App\Repositories\OfficeRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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
        $this->app->singleton(
            AuthContract::class,
            AuthRepository::class
        );
        $this->app->singleton(
            OfficeContract::class,
            OfficeRepository::class,
        );
        $this->app->singleton(
            LocationContract::class,
            LocationRepository::class,
        );
    }
}
