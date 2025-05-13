<?php

namespace App\Providers;

use App\Contracts\PatientRepositoryInterface;
use App\Contracts\PatientServiceInterface;
use App\Repositories\PatientRepository;
use App\Services\PatientService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PatientRepositoryInterface::class, PatientRepository::class);
        $this->app->bind(PatientServiceInterface::class, PatientService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
