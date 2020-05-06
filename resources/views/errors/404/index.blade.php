@extends('layout.app')

@section('title', '400')
@section('bodyClass', 'fixed-header error-page')

@section('content')
    <div class="d-flex justify-content-center full-height full-width align-items-center">
        <div class="error-container text-center">
            <h1 class="error-number">404</h1>
            <h2 class="semi-bold">Sorry but we couldnt find this page</h2>
            <p class="p-b-10">This page you are looking for does not exsist <a href="#">Report this?</a>
            </p>
        </div>
    </div>
@endsection

@section('script')
    @include('errors.404.scripts.index')
@endsection

@section('formValidationScript')
    @include('errors.404.scripts.form')
@endsection
