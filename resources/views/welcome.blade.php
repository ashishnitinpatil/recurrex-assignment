@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    <button type="submit" class="btn btn-primary" onclick="location.href='/login'">
                        <i class="fa fa-btn fa-sign-in"></i> Login
                    </button>
                    <button type="submit" class="btn btn-primary" onclick="location.href='/register'">
                        <i class="fa fa-btn fa-user"></i> Register
                    </button>
                    <button type="submit" class="btn btn-primary" onclick="location.href='/register/admin'">
                        <i class="fa fa-btn fa-user"></i> Register as Admin
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
