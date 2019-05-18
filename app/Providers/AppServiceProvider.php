<?php

namespace App\Providers;

use App\Category;
use App\Genre;
use App\Language;
use Illuminate\Support\Facades\View;
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
        $categories = Category::all();
        $genres = Genre::all();
        $languages = Language::all();
        View::share('categories', $categories);
        View::share('genres', $genres);
        View::share('languages', $languages);

    }
}
