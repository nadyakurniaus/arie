@extends('back.layouts-adminsys.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/select2/select2.min.css') }}">
@stop

@section('body')
<!-- Page -->
<div class="page">
        <div class="page-header">
            <h1 class="page-title">Pengguna </h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Admin System</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Kelola Pengguna</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
            </div>
<div class="page vertical-align text-xs-center">>
    <div class="page-content vertical-align-middle animation-slide-top animation-duration-1">
      <div class="panel "style="
      width: 500px;
      height: 590px;">
        <div class="panel-body">
          <div class="brand">
            <img class="brand-img" src="{{asset('global/assets/images/logo-blue.png')}}">
            <h2 class="brand-text font-size-18">Form Tambah Pengguna</h2>
          </div>
          <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group form-material floating" data-plugin="formMaterial">
                <input type="text" class="form-control" name="idUser" value="{{$kodeuser}}" readonly/>
                <label class="floating-label">ID Pengguna</label>
              </div>
            <div class="form-group form-material floating" data-plugin="formMaterial">
              <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus/>
              <label class="floating-label">Nama</label>
                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group form-material floating" data-plugin="formMaterial">
                <input type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus/>
                <label class="floating-label">Username</label>
                  @if ($errors->has('username'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->firt('username') }}</strong>
                      </span>
                  @endif
              </div>
            <div class="form-group form-material floating" data-plugin="formMaterial">
              <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required  />
              <label class="floating-label">Email</label>
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div><label class="" style="margin-bottom: 10px;">Level :</label>
            <div class="form-group form-material" data-plugin="formMaterial" >
              <select name="role" id="role" class="form-control select2">
                 <option value="">-Pilih Salah Satu-</option>
                <option value="admin">Admin</option>
                <option value="gudang">Bagian Gudang</option>
                <option value="finance">Bagian Finance</option>
                <option value="supervisor">Supervisor Produksi</option>
                <option value="setting">Bagian Setting</option>
                <option value="manajer">Manajer</option>
                <option value="direktur">Direktur</option>
                <option value="adminsystem">Admin System</option>
                <option value="offset">Bagian Offset</option>
                <option value="cutting">Bagian Cutting</option>
                <option value="finishing">Bagian Finishing</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-lg m-t-40">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>

    @include('back.layouts.modal')
    @stop
    @section('script')
    <script src="{{ asset('global/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('js/select2Ajax.js') }}"></script>
    <script src="{{ asset('js/selectBy.js') }}"></script>
    <script src="{{ asset('global/vendor/select2/select2.min.js') }}"></script>
    <script type="text/javascript">
       $(function() {
    $('#role').select2();
  })

    </script>
    @if($errors->any())
    <script>
      toastr["error"]("@foreach($errors->all() as $x) {{ $x }} <br> @endforeach", "Error");
    </script>
    @endif
    @if(session('message'))
    <script>
      toastr["info"]("{{ session('message') }}", "Success");
    </script>
    @endif
@stop

@section('script')

@stop
