<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Query\Builder;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('if', function ($condition, $column, $operator, $value) {
            if ($condition) {
                return $this->where($column, $operator, $value);
            }

            return $this;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }


}
