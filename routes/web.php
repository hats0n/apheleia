<?php

use App\DB\ProductsStore;
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
Route::get('/admin', function (ProductsStore $store) {
    $ret = $store->searchProduct("");
    return view('admin_product_list', ['products'=>$ret['products']]);
});

Route::get('/admin/product/add', function () {
    return view('admin_product', ['product' => null]);
});

Route::get('/admin/product/{product_id}/delete', function (ProductsStore $store, Request $request, $product_id) {
    $store->deleteProduct($product_id);
    $request->session()->flash('message.level', 'success');
    $request->session()->flash('message.content', "Product removed successfully!($product_id)");
    return redirect()->back();

});

Route::post('/admin/product/save', function (ProductsStore $store, Request $request) {
    $post_data = $request->input();
    $product_id = $store->saveNewProduct($post_data);
    $request->session()->flash('message.level', 'success');
    $request->session()->flash('message.content', "Product added successfully!($product_id)");
    return redirect()->back();
});

Route::get('/user/products', function (ProductsStore $store, Request $request) {
    $query = $request->query('query');
    $color_filters = $request->query('color');
    $ret = $store->searchProduct($query, $color_filters);
    return view('user_product_list', [
        'products'=>$ret['products'],
        'query' => $query,
        'selected_colors' => $color_filters,
        'colors' => array_keys($ret['colors'])
    ]);
});

Route::get('/user/products/{product_id}', function (ProductsStore $store, Request $request, $product_id = null) {
    if (!$product_id) {
        $request->session()->flash('message.level', 'danger');
        $request->session()->flash('message.content', "Product identifier not found");
        redirect()->back();
    }
    $product = $store->getSingleProduct($product_id);
    return view('user_product_view', ['product'=>$product]);
});