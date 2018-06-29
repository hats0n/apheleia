<?php

namespace App\Providers;

use App\DB\ElasticsearchProductsStore;
use App\DB\ProductsStore;
use Illuminate\Support\ServiceProvider;

class ProductsStoreServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    protected $defer = true;
    public function register()
    {
        $this->app->singleton(ProductsStore::class, function($app)
        {
            return new ElasticsearchProductsStore(env('ELASTIC_HOST', '127.0.0.1'));
        });
    }
}
