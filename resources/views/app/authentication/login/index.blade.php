@extends('layout.authentication')

@section('title', 'Login')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="login-wrapper bg-white" style="margin-top: -30px;">
        <div class="login-container bg-white" style="width: 496px;display: block;position: relative;margin: 0px auto;float:unset;padding-top: 5%;">
            <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-0 m-t-0 sm-p-l-15 sm-p-r-15 sm-p-t-0 text-center">
                <h1>Login</h1>
                <form id="loginForm" class="p-t-15" role="form">
                    <div class="form-group form-group-default">
                        <div class="controls">
                            <input type="text" name="username" placeholder="Username" class="form-control">
                        </div>
                    </div>
                    <div class="form-group form-group-default">
                        <div class="controls">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center m-t-10">
                            <button class="btn btn-primary m-t-10 w-100" type="submit">Sign in</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center m-t-10">
                            <a href="/register" class="text-info small">Register</a>
                        </div>
                    </div>
                </form>
                <!--END Login Form-->
            </div>
        </div>
        <!-- END Login Right Container-->
    </div>
@endsection

@section('script')
    @include('app.authentication.login.scripts.index')
@endsection

@section('formValidationScript')
    @include('app.authentication.login.scripts.form')
@endsection
