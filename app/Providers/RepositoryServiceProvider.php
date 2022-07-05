<?php

namespace App\Providers;

use App\Contracts\OfficeContract;
use App\Contracts\LocationContract;
use App\Contracts\TeamContract;
use App\Contracts\UserContract;
use App\Repositories\OfficeRepository;
use App\Repositories\LocationRepository;
use App\Repositories\TeamRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepository;
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
            UserContract::class,
            UserRepository::class
        );
        $this->app->singleton(
            OfficeContract::class,
            OfficeRepository::class,
        );
        $this->app->singleton(
            LocationContract::class,
            LocationRepository::class,
        );
        $this->app->singleton(
            TeamContract::class,
            TeamRepository::class,
        );
    }
}
