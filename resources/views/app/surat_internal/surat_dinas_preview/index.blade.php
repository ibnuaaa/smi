@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')
    <div class="jumbotron jumbotron m-b-0" data-pages="parallax">
        <div class="container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
            <div class="inner">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Preview Surat Dinas</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container-fluid container-fixed-lg p-t-10">
        <div class="card card-white">
            <div class="card-header ">
            </div>
            <div class="card-body">
                <table class="preview">
                    <tr>
                        <td class="text-center">
                            <img src="/assets/img/logo-kemendagri.png" width="100px" />
                        </td>
                        <td class="text-center">
                            <h2>
                                KEMENTERIAN DALAM NEGERI<br />
                                REPUBLIK INDONESIA<br />
                                SATUAN KERJA<br />
                            </h2>
                        </td>
                    </tr>
                    <tr class="text-center">
                        <td></td>
                        <td>
                            Jalan : ....................................
                            Nomor : ....................................
                            No Telepon : ....................................
                            <br/>
                            Fax : ....................................
                            www.kemendagri.go.id
                            Email : ...................................
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nomor
                        </td>
                        <td>
                            : ......../......../........
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Sifat
                        </td>
                        <td>
                            :
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Lampiran
                        </td>
                        <td>
                            :
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Hal
                        </td>
                        <td>
                            :
                        </td>
                    </tr>
                    
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('app.surat_internal.surat_dinas_preview.style.index')
@endsection