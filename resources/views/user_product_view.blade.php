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
        <div class="row">
            <div class="col-md-12">
                <h4>{{$product->getTitle()}}</h4>
                <p>{{$product->getDescription()}}</p>
                @foreach ($product->getVariants() as $variant)
                    <b>{{$variant->getColor()}}</b>: <span>{{$variant->getPrice()}}</span><br/>
                @endforeach
            </div>
        </div>
    </div>
@stop

