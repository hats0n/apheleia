@extends('layout')

@section('title', 'Login')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="/login" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
                <a href="/signup"> <button class="btn btn-primary">Signup</button></a>
            </div>
        </div>
    </div>
@stop

