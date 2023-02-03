<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class BlueprintServiceProvider extends ServiceProvider
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
        Blueprint::macro('sortable', function () {
            $this->bigInteger('sort_num')->nullable()
                ->unsigned();
        });

        Blueprint::macro('status', function () {
            $this->string('status')
                ->default('public');
        });

        Blueprint::macro('schedule', function () {
            $this->dateTime('publish_at')->nullable();
            $this->dateTime('expires_at')->nullable();
        });
        
    }
}
