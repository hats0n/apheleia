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
                <h4>{{$product['title']}}</h4>
                <p>{{$product['description']}}</p>
                @foreach ($product['variants'] as $variant)
                    <b>{{$variant['color']}}</b>: <span>{{$variant['price']}}</span><br/>
                @endforeach
            </div>
        </div>
    </div>
@stop

