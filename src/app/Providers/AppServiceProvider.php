<?php

namespace App\Providers;

use App\Http\Resources\UserResource;
use App\Http\Resources\GenreResource;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        UserResource::withoutWrapping();
        GenreResource::withoutWrapping();
    }
}
