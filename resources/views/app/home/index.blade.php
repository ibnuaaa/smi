@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg row">
        <div class="card card-white col-md-12">
            <div class="card-header ">
                <div class="text-center">

                		<h2 class="bold">
	                    SELAMAT DATANG<br/>
	                    DI<br/>
	                     <font color="blue"><i>SMI</font> <br/>
	                  </h2>

                    <br/><br/>

                    <p class="text-dark">
                    	Data dan Informasi dalam sistem ini bersifat <font color="red"><b>RAHASIA</b></font> yang hanya digunakan untuk kepentingan lingkungan SMI sehingga diharapkan kepada seluruh pegawai di lingkungan SMI untuk tetap menjaga kerahasiaan dokumen serta melakukan penggantian password secara berkala. Informasi lebih lanjut dapat menghubungi contact center SMI
                    </p>

                </div>
            </div>
            <div class="card-body">

            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('app.home.scripts.index')
@endsection

@section('formValidationScript')
    @include('app.home.scripts.form')
@endsection
