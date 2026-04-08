<?php

namespace App\Providers;

use App\Repositories\Interfaces\PenggunaRepositoryInterface;
use App\Repositories\Interfaces\ProyekRepositoryInterface;
use App\Repositories\Interfaces\TugasRepositoryInterface;
use App\Repositories\PenggunaRepository;
use App\Repositories\ProyekRepository;
use App\Repositories\TugasRepository;
use Illuminate\Support\ServiceProvider;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PenggunaRepositoryInterface::class, PenggunaRepository::class);
        $this->app->bind(ProyekRepositoryInterface::class, ProyekRepository::class);
        $this->app->bind(TugasRepositoryInterface::class, TugasRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
