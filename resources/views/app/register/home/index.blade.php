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
                <button aria-label="" class="btn btn-cons m-t-10" type="submit">Login</button>
                <button aria-label="" class="btn btn-primary btn-cons m-t-10" type="submit">Buat Akun Baru</button>
            </div>
          </div>
          <br>
        </form>
      </div>
    </div>
@endsection
