@extends('layout')

@section('title', 'Admin panel')
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
        <div class="row">
            <div class="col-md-12">
                <a href="/admin/product/add"><button type="button" class="btn btn-primary">Add new product</button></a>
            </div>
        </div>
        <div class="row">
            @foreach ($products as $product)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">{{$product->getTitle()}}</a>
                            </h4>
                            <p class="card-text">{{$product->getDescription()}}</p>
                        </div>
                        <div class="card-footer">
                            <a data-confirm="Are you sure?" data-method="delete" href="/admin/product/{{$product->getId()}}/delete" rel="nofollow">
                                <button type="button" class="btn btn-primary">Remove</button>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop

