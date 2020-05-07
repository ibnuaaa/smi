@extends('layout.app')

@section('title', 'Information')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="card card-white">
            <div class="card-header ">
                <div class="card-title">Formulir Pembiayaan Daerah</div><br>
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
                            <th style="position: relative;cursor: pointer;width:80px;" onClick="sortBy('id', '' )">
                               ID
                            </th>
                            <th style="position: relative;cursor: pointer" onClick="sortBy('title', '' )">
                               Pemerintah Daerah
                            </th>
                            <th style="position: relative;cursor: pointer" onClick="sortBy('content', '' )">
                               Nilai Permohonan
                            </th>
                            <th style="position: relative;cursor: pointer" onClick="sortBy('created_at', '' )">
                               Sektor
                            </th>
                            <th style="position: relative;cursor: pointer" onClick="sortBy('created_at', '' )">
                               Tenor
                            </th>
                            <th style="position: relative;cursor: pointer" onClick="sortBy('created_at', '' )">
                               Status
                            </th>
                            <th style="position: relative;cursor: pointer" onClick="sortBy('created_at', '' )">
                               Action
                            </th>
                         </tr>
                      </thead>
                      <tbody>
                         <tr>
                            <td class="v-align-middle ">
                               <p>1</p>
                            </td>
                            <td class="v-align-middle ">
                               <p>Jawa Barat</p>
                            </td>
                            <td class="v-align-middle ">
                               <p>Rp 2.000.000,00</p>
                            </td>
                            <td class="v-align-middle ">
                               <p>Sekolah</p>
                            </td>
                            <td class="v-align-middle ">
                               <p>2 Tahun</p>
                            </td>
                            <td class="v-align-middle ">
                               <label class="btn btn-warning btn-xs">Pending</label>
                            </td>
                            <td class="v-align-middle">
                               <div class="btn-group">
                                  <a href="/master_data_pemda/1" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                  <a href="#modalDelete" data-toggle="modal" data-record-id="1" data-record-name="" class="btn btn-danger">
                                  <i class="fas fa-trash-alt"></i>
                                  </a>
                               </div>
                            </td>
                         </tr>
                         <tr>
                            <td class="v-align-middle ">
                               <p>2</p>
                            </td>
                            <td class="v-align-middle ">
                               <p>Aceh</p>
                            </td>
                            <td class="v-align-middle ">
                               <p>Rp 2.000.000,00</p>
                            </td>
                            <td class="v-align-middle ">
                               <p>Jembatan</p>
                            </td>
                            <td class="v-align-middle ">
                               <p>2 Tahun</p>
                            </td>
                            <td class="v-align-middle ">
                               <label class="btn btn-primary btn-xs">Approved</label>
                            </td>
                            <td class="v-align-middle">
                               <div class="btn-group">
                                  <a href="/master_data_pemda/1" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                  <a href="#modalDelete" data-toggle="modal" data-record-id="1" data-record-name="" class="btn btn-danger">
                                  <i class="fas fa-trash-alt"></i>
                                  </a>
                               </div>
                            </td>
                         </tr>
                         <tr>
                            <td class="v-align-middle ">
                               <p>3</p>
                            </td>
                            <td class="v-align-middle ">
                               <p>Aceh</p>
                            </td>
                            <td class="v-align-middle ">
                               <p>Rp 2.000.000,00</p>
                            </td>
                            <td class="v-align-middle ">
                               <p>Tempat Ibadah</p>
                            </td>
                            <td class="v-align-middle ">
                               <p>2 Tahun</p>
                            </td>
                            <td class="v-align-middle ">
                               <label class="btn btn-success btn-xs">Finish</label>
                            </td>
                            <td class="v-align-middle">
                               <div class="btn-group">
                                  <a href="/master_data_pemda/1" class="btn btn-info"><i class="fas fa-eye"></i></a>
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
