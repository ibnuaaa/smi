@extends('layout.authentication')

@section('title', 'Login')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="register-container full-height sm-p-t-30">
      <div class="d-flex justify-content-center flex-column full-height ">

        <h1>REFINA - Register</h1>
        <p>
          Formulir pendaftaran user pemda baru
        </p>

        <form id="form-register" class="p-t-15" role="form" action="index.html">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group form-group-default">
                <label>Pemerintah daerah</label>
                <select class=" full-width" data-init-plugin="select2">
                  <option value="Jim">Provinsi Aceh</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group form-group-default">
                <label>Nilai PIC/Contact person</label>
                <input type="text" name="uname" placeholder="" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group form-group-default">
                <label>Jabatan PIC / Contact person</label>
                <input type="text" name="uname" placeholder="" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group form-group-default">
                <label>Email PIC/Contact Person</label>
                <input type="text" name="uname" placeholder="" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group form-group-default">
                <label>Nomor HP PIC/Contact Person</label>
                <input type="text" name="uname" placeholder="" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <a href="/login" class="btn btn-cons m-t-10" >Login</a>
                <a href="#modalConfirm" class="btn btn-primary m-t-10" type="submit" data-toggle="modal" data-record-id="1" data-record-name="">Buat Akun Baru</a>
            </div>
          </div>
          <br>
        </form>
      </div>
    </div>
    <div class="modal fade slide-up disable-scroll" id="modalConfirm" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fas fa-times fs-14"></i>
                        </button>
                        <h5>Konfirmasi <span class="semi-bold">User</span></h5>
                        <p class="p-b-10">Masukkan kode otentikasi dikirim ke nomor telepon atau email</p>
                        <input type="text" class="form-control" />
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                            </div>
                            <div class="col-md-4 m-t-10 sm-m-t-10">
                                <a href="/" class="btn btn-block btn-primary btn-cons m-b-10"><i class="fas fa-check"></i> &nbsp;&nbsp; Confirm</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
