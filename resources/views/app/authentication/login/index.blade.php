@extends('layout.authentication')

@section('title', 'Login')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="login-wrapper bg-white" style="background: url('{{ url('/assets/img/bg-02.jpg') }}');background-size: cover;background-repeat: no-repeat;background-position: center;">
        <div class="login-container" style="display: block;position: relative;margin: 0px auto;float:unset;padding-top: 5%;">
            <div class="p-l-50 p-b-30 m-l-20 p-r-50 m-r-20 p-t-30 m-t-0 sm-p-l-10 sm-p-r-10 sm-p-t-30 text-center" style="background: rgba(13, 58, 105, 0.6); border-radius: 20px;">
                <img src="/assets/img/logo-text.png" width="300">
                <!-- START Login Form -->
                <form id="loginForm" class="p-t-15" role="form" style="opacity: 1 !important;">
                    <div class="form-group form-group-default" >
                        <div class="controls">
                            <input type="text" name="username" placeholder="NIP" class="form-control">
                        </div>
                    </div>
                    <div class="form-group form-group-default">
                        <div class="controls">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group hide">
                        <div class="row mb-2">
                            <div class="mr-3" id="i-captcha"></div>
                            <i class="fa fa-refresh pointer mt-2" id="btnRefreshCaptcha"></i>
                        </div>
                        <input type="text" class="form-control form-control-custom" style="height: 40px !important;" name="captcha" autocomplete="off" id="i-captcha-val" placeholder="isi captcha">
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center m-t-10">
                            <button class="btn btn-primary m-t-10 w-100" type="submit">Sign in</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center m-t-10 text-center">
                            <hr />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center m-t-10 text-center" style="color: #fff;">
                            Sertifikat Elektronik Dijamin oleh :
                            <br />
                            <img src="{{ url('/assets/img/logo-bsre.png') }}" width="100px" />
                            <br />
                            © 2020 All Rights Reserved.
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
