<?php

namespace App\Providers;

use App\DB\RedisUsersStore;
use App\DB\UsersStore;
use Illuminate\Support\ServiceProvider;

class UsersStoreServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

//    protected $defer = true;
    public function register()
    {
        $this->app->singleton(UsersStore::class, function($app)
        {
            return new RedisUsersStore([
                'host' => env('REDIS_HOST', null),
                'port' => env('REDIS_PORT', null)
            ]);
        });
    }
}
