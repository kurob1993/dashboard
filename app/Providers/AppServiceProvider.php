<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
		//Get route instance
		
		//$routes = $this->app['router']->getRoutes();

		//Replace UrlGenerator with CustomUrlGenerator
		//$customUrlGenerator = new CustomUrlGenerator($routes, $this->app->make('request'));
		//$this->app->instance('url', $customUrlGenerator);
    }
}
