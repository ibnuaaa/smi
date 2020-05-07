@extends('layout.app')

@section('title', 'Information')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg">
        <nav class="navbar navbar-default bg-transparent sm-padding-10 full-width p-t-0 p-b-0 m-b-0" role="navigation">
            <div class="container-fluid full-width">
                <div class="navbar-header text-center">
                    <button type="button" class="navbar-toggle collapsed btn btn-link no-padding" data-toggle="collapse" data-target="#sub-nav">
                        <i class="pg pg-more v-align-middle"></i>
                    </button>
                </div>
                <div class="collapse navbar-collapse">
                    <div class="row">
                        <div class="col-sm-4">
                            <ul class="navbar-nav d-flex flex-row">
                                <li class="nav-item">
                                    <a href="{{ url('/master_data_pemda/new') }}"><i class="fas fa-plus"></i> Create</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-4">
                            <ul class="navbar-nav d-flex flex-row">
                            </ul>
                        </div>
                        <div class="col-sm-4">
                            <ul class="navbar-nav d-flex flex-row justify-content-sm-end">
                                <li class="nav-item"><a href="#" class="p-r-10" onclick="$.Pages.setFullScreen(document.querySelector('html'));"><i class="fa fa-expand"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div class="card card-white">
            <div class="card-header ">
                <div class="card-title">Data Pemda</div><br>
            </div>
            <div class="card-body">




                <div class="blade-datatable table-responsive">
                   <div class="row blade-datatable-header">
                      <div class="col-12 blade-datatable-header-panel">
                         <div class="row">
                            <div class="col-8">
                               <div class="blade-datatable-sort">
                                  <p>Show</p>
                                  <div class="dropdown dropdown-default">
                                     <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                     10
                                     </button>
                                     <div class="dropdown-menu">
                                        <a class="dropdown-item" href="/information?information-table-take=10">10</a>
                                        <a class="dropdown-item" href="/information?information-table-take=25">25</a>
                                        <a class="dropdown-item" href="/information?information-table-take=50">50</a>
                                        <a class="dropdown-item" href="/information?information-table-take=100">100</a>
                                     </div>
                                  </div>
                                  <p>Entries</p>
                               </div>
                            </div>
                            <div class="col-4">
                               <form action="/information">
                               <div class="input-group">
                                  <input  name="information-table-filter_search"
                                     placeholder="Search... (Judul, Desk)"
                                     value=""
                                     class="form-control"
                                     type="text">
                                  <div class="input-group-append">
                                     <button type="submit" class="input-group-text info pointer"><i class="fa fa-search"></i></button>
                                  </div>
                               </div>
                               </from>
                            </div>
                         </div>
                      </div>
                   </div>
                   <table class="table table-hover table-condensed">
                      <thead>
                         <tr>
                            <th style="position: relative;cursor: pointer" onClick="sortBy('id', '' )">
                               ID
                            </th>
                            <th style="position: relative;cursor: pointer" onClick="sortBy('title', '' )">
                               Nama
                            </th>
                            <th style="position: relative;cursor: pointer" onClick="sortBy('content', '' )">
                               Deskripsi
                            </th>
                            <th style="position: relative;cursor: pointer" onClick="sortBy('created_at', '' )">
                               created_at
                            </th>
                            <th style="position: relative;cursor: pointer" onClick="sortBy('action', '' )">
                               action
                            </th>
                         </tr>
                      </thead>
                      <tbody>
                         <tr>
                            <td class="v-align-middle ">
                               <p>1</p>
                            </td>
                            <td class="v-align-middle ">
                               <p>Aceh</p>
                            </td>
                            <td class="v-align-middle ">
                               <p>-</p>
                            </td>
                            <td class="v-align-middle ">
                               <p></p>
                            </td>
                            <td class="v-align-middle">
                               <div class="btn-group">
                                  <a href="/master_data_pemda/1" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                  <a href="/master_data_pemda/edit/1" class="btn btn-success"><i class="fas fa-pencil-alt"></i></a>
                                  <a href="#modalDelete" data-toggle="modal" data-record-id="1" data-record-name="" class="btn btn-danger">
                                  <i class="fas fa-trash-alt"></i>
                                  </a>
                               </div>
                            </td>
                         </tr>

                      </tbody>
                   </table>
                   <div class="row blade-datatable-footer">
                      <div class="blade-datatable-footer-panel">
                         <div class="blade-datatable-paginate">
                            <ul class="row" style="list-style: none;">
                               <li class="paginate_button previous disabled">
                                  <a>
                                  <i class="pg-arrow_left"></i>
                                  </a>
                               </li>
                               <li class="paginate_button active">
                                  <a href="?information-table-page=1">1</a>
                               </li>
                               <li class="paginate_button next">
                                  <a>
                                  <i class="pg-arrow_right"></i>
                                  </a>
                               </li>
                            </ul>
                         </div>
                         <div class="blade-datatable-info">
                            Showing <b>1 to 2</b> of 2 entries
                         </div>
                      </div>
                   </div>
                </div>


























            </div>
        </div>
    </div>
    {{-- Detail Modal --}}
    <div class="modal fade slide-up disable-scroll" id="modalDelete" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                        <h5>Delete <span class="semi-bold">User</span></h5>
                        <p class="p-b-10">Are you sure you want to delete this entries?</p>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                            </div>
                            <div class="col-md-4 m-t-10 sm-m-t-10">
                                <button id="deleteAction" class="btn btn-block btn-danger btn-cons m-b-10"><i class="fas fa-trash"></i> Yes Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- /.Delete Modal --}}
@endsection

@section('script')
    @include('app.information.home.scripts.index')
@endsection
