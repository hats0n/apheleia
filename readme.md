# Apheleia
Apheleia is a very very very (again, very) simple ecommerce website implemented as a technical examination task for the YOU KNOW WHO company.

## Downsides
 - at the end of the implementation, I realized that I should've used Symfony Components :( . So as you can guess, I didn't do that directly on my implementations and this code is based on Laravel framework. but laravel itself uses Symfony Components internally, so I hope it counts :D. I think it's Po-tay-to po-tah-to afterall..
 - There's no "product-edit" feature exists.. It's already 3AM and it was the best I could do in a couple hours :(
 - There's no price range filter. The reason is the same as above.

## General description
This project uses Redis to store user credentials, Elasticsearch for storing and searching product catalog, and Memcached for caching elassticsearch's search result.

## Where to look for my actucal implementations?

There is a whole bunch of files within Laravel's standard directory structure. You can find my implementations in following paths:
 - `app/Cache/*` 
 - `app/DB/*`
 - `app/Http/Middleware/CustomAuthentication.php`
 - `app/Models/*`
 - `app/Providers/ProductsStoreServiceProvider.php`
 - `app/Providers/UsersStoreServiceProvider.php`
 - `resources/view/*`
 - `routes/web.php`

## Requirements
This project excepts an elasticsearch, redis, and memcached server on localmachine. host configuration is available within .env files.

## How to run
just run `php atrisan serve` to start the webserver.
