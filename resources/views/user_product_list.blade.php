@extends('layout')

@section('title', 'ProductList')
@section('action-stylesheet')
<style>
    .card {
        border: 1px solid lightgray;
        margin-top:10px; margin-bottom: 10px;
        padding: 10px;
    }
</style>
@stop
@section('content')
    <div class="container">
        <form method="GET">
            <div class="form-group">
                <label for="product_search_box">Search</label>
                <input type="text" class="form-control" id="product_search_box" name="query" placeholder="Search your product" required>
            </div>
        </form>
        <div class="container">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-8">
                    <div class="container-fluid">
                        <div class="row">
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">
                                                <a href="/user/products/{{$product['_id']}}">{{ $product['title'] }}</a>
                                            </h4>
                                            <p class="card-text">{{ $product['description'] }}</p>
                                        </div>
                                        <div class="card-footer">
                                            <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

