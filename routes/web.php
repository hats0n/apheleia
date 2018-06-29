<?php

use App\DB\ProductsStore;
use App\DB\UsersStore;
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
})->middleware('sessionLoggedIn');

Route::get('/user/products/{product_id}', function (ProductsStore $store, Request $request, $product_id = null) {
    if (!$product_id) {
        $request->session()->flash('message.level', 'danger');
        $request->session()->flash('message.content', "Product identifier not found");
        redirect()->back();
    }
    $product = $store->getSingleProduct($product_id);
    return view('user_product_view', ['product'=>$product]);
})->middleware('sessionLoggedIn');

Route::get('/signup', function () {
    return view('signup');
});

Route::post('/signup', function (UsersStore $userStore, Request $request) {
    $email = $request->input('email') or null;
    $password = $request->input('password') or null;
    if (!$email || !$password) {
        $request->session()->flash('message.level', 'danger');
        $request->session()->flash('message.content', "Username/Password not provided");
        redirect()->back();
    }
    $userStore->addUser($email, $password);

    $request->session()->flash('message.level', 'success');
    $request->session()->flash('message.content', "User added successfully!");
    return redirect('/login');

});

Route::get('/login', function (Request $request) {
    return view('login');
})->middleware('sessionLoggedIn');

Route::post('/login', function (UsersStore $userStore, Request $request) {
    $email = $request->input('email') or null;
    $password = $request->input('password') or null;
    if (!$email || !$password) {
        $request->session()->flash('message.level', 'danger');
        $request->session()->flash('message.content', "Username/Password not provided");
        redirect()->back();
    }
    if (!$userStore->checkUser($email, $password)) {
        $request->session()->flash('message.level', 'danger');
        $request->session()->flash('message.content', "Incorrect Username/Password");
        return redirect()->back();
    }
    $request->session()->put('is_logged_in', true);
    return redirect('user/products');
});

Route::get('/logout', function (Request $request) {
    $request->session()->remove('is_logged_in');
    return view('login');
});