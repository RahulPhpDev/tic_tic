<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

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
    	 Schema::defaultStringLength(191);
        Builder::macro('whereLike', function (string $attribute, string $searchItem) {
            return $this->orWhere($attribute, 'LIKE', "%{$searchItem}%");
        });

        // Builder::macro('section', function () {
        //     return \App\Models\Section::pluck('name', 'id');
        // });
        View::share('key', 'value');


    }
}
