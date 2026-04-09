<?php

namespace App\Providers;

use App\Repositories\CartRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CostumRepository;
use App\Repositories\FinanceRepository;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\CostumRepositoryInterface;
use App\Repositories\Interfaces\FinanceRepositoryInterface;
use App\Repositories\Interfaces\MaintenanceRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Repositories\Interfaces\RatingRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\MaintenanceRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\RatingRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CostumRepositoryInterface::class, CostumRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(FinanceRepositoryInterface::class, FinanceRepository::class);
        $this->app->bind(MaintenanceRepositoryInterface::class, MaintenanceRepository::class);
        $this->app->bind(RatingRepositoryInterface::class, RatingRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
