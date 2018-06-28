<?php

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});
Route::get('/admin', function () {
    $client = \Elasticsearch\ClientBuilder::create()->build();
    $resp = $client->search([
        'q' => "*",
        'size'=> 100
    ]);
    $products = [];
    foreach ($resp['hits']['hits'] as $doc) {
        $products[] = ["_id"=> $doc['_id']] +   $doc['_source'];
    }
    return view('admin_product_list', ['products'=>$products]);
});

Route::get('/admin/product/add', function () {
    return view('admin_product', ['product' => null]);
});

Route::get('/admin/product/{product_id}/delete', function (Request $request, $product_id) {
    $client = \Elasticsearch\ClientBuilder::create()->build();
    $client->delete([
        'index' => 'products',
        'type' => '_doc',
        'id' => $product_id,
    ]);

    $request->session()->flash('message.level', 'success');
    $request->session()->flash('message.content', "Product removed successfully!($product_id)");
    return redirect()->back();

});

Route::post('/admin/product/save', function (Request $request) {
    $post_data = $request->input();
    $client = \Elasticsearch\ClientBuilder::create()->build();

    $full_text_search = '';
    $variants = [];
    foreach ($post_data['product_color'] as $index => $color) {
        $variants[] = ['color' => $color, 'price' => (float)($post_data['product_price'][$index])];
        $full_text_search .= " $color";
    }
    $resp = $client->index([
        'index'=> 'products',
        'type' => '_doc',
        'body'=>[
            'title' => $post_data['product_title'],
            'description' => $post_data['product_description'],
            'variants' => $variants,
            'full_text_search' => "{$post_data['product_title']} {$post_data['product_description']} $full_text_search",
        ]
    ]);
    $product_id = $resp['_id'];

    $request->session()->flash('message.level', 'success');
    $request->session()->flash('message.content', "Product added successfully!($product_id)");
    return redirect()->back();
});

Route::get('/user/products', function (Request $request) {
    $query = $request->query('query') or "*";
    $client = \Elasticsearch\ClientBuilder::create()->build();
    $resp = $client->search([
        'q' => $query,
        'size'=> 100
    ]);
    $products = [];
    foreach ($resp['hits']['hits'] as $doc) {
        $products[] = ["_id"=> $doc['_id']] +   $doc['_source'];
    }
    return view('user_product_list', ['products'=>$products]);
});

Route::get('/user/products/{product_id}', function (Request $request, $product_id = null) {
    if (!$product_id) {
        $request->session()->flash('message.level', 'danger');
        $request->session()->flash('message.content', "Product identifier not found");
        redirect()->back();
    }
    $resp = \Elasticsearch\ClientBuilder::create()->build()->get([
        'id'=> $product_id,
        'type' => '_doc',
        'index' => 'products'
    ]);

    $product = $resp['_source'] + ['_id' => $resp['_id']];
    return view('user_product_view', ['product'=>$product]);
});