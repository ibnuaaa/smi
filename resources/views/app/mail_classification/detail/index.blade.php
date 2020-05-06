@extends('layout.app')

@section('title', 'User '.$data['name'])
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="jumbotron jumbotron m-b-0" data-pages="parallax">
        <div class="container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
            <div class="inner">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/information') }}">User</a></li>
                    <li class="breadcrumb-item active">Detail #{{ $data['name'] }}</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container-fluid container-fixed-lg">
        <div class="card card-default m-t-20">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="font-montserrat all-caps hint-text">Information Detail</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        Title
                    </div>
                    <div class="col-md-10">
                        {{ $data['title'] }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        Content
                    </div>
                    <div class="col-md-10">
                        {{ $data['content'] }}
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@section('script')
    @include('app.information.detail.scripts.form')
@endsection
