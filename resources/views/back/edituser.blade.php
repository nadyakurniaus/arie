@if (Auth::user()->role == 'admin')
@extends('back.layouts.base')
@endif
@if (Auth::user()->role == 'gudang')
@extends('back.layouts-gudang.base')
@endif
@if (Auth::user()->role == 'finance')
@extends('back.layouts-finance.base')
@endif
@if (Auth::user()->role == 'setting')
@extends('back.layouts-setting.base')
@endif
@if (Auth::user()->role == 'supervisor')
@extends('back.layouts-supervisor.base')
@endif
@if (Auth::user()->role == 'manajer')
@extends('back.layouts-manajer.base')
@endif
@if (Auth::user()->role == 'adminsystem')
@extends('back.layouts-adminsys.base')
@endif

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/select2/select2.min.css') }}">
@stop

@section('body')

<div class="page">
  <div class="page-header">
    <h1 class="page-title">Ganti Password</h1>
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">{{Auth::user()->role}}</a></li>
      <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
      <li class="breadcrumb-item active">Ganti Password</li>
    </ol>
    <div class="page-header-actions">
        <form action="{{ route('product.update', $user->id) }}" method="POST" autocomplete="off">
                <input name="_method" type="hidden" value="PATCH">
            @csrf
      <a href="{{ route('produk.index') }}" class="btn btn-md btn-icon btn-outline btn-warning btn-round" data-toggle="tooltip" data-original-title="Go back to role index">
        <i class="icon wb-arrow-left" aria-hidden="true"></i> &nbsp; Kembali
      </a>
      <button type="submit" class="btn btn-md btn-icon btn-primary btn-round" data-toggle="tooltip" data-original-title="Save">
        <i class="icon wb-check" aria-hidden="true"></i> &nbsp; Ubah
      </button>
    </div>
  </div>

  <div class="page-content container-fluid">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 col-xs-12">
        <!-- Panel Static Labels -->
        <div class="panel">
          <div class="panel-heading">
          <h3 class="panel-title">Edit {{ $user->name }}</h3>
          </div>
          <div class="panel-body container-fluid">
              <div class="form-group form-material" data-plugin="formMaterial">
                  <label class="label" for="inputText">Nama</label>
                <input type="text" class="form-control" id="inputText" name="nama" value="{{ $user->name }}"  readonly/>
              </div>
              <div class="form-group form-material" data-plugin="formMaterial">
                <label class="label" for="inputText">Username</label>
                <input type="text" class="form-control" id="inputText" name="username" value="{{ $user->username }}" readonly>
              </div>
                <div class="form-group form-material" data-plugin="formMaterial">
                    <label class="label" for="inputText">Email</label>
                    <input type="text" class="form-control" id="inputText" name="email" value="{{ $user->email }}" readonly/>
                </div>
                <div class="form-group form-material" data-plugin="formMaterial">
                    <label class="label" for="inputText">Role</label>
                    <input type="text" class="form-control" id="inputText" name="role" value="{{ $user->role }}" readonly/>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- End Panel Floating Labels -->
      </div>
    </div>
  </div>
</div>


@stop

@section('script')
<script src="{{ asset('global/js/Plugin/material.js') }}"></script>
<script src="{{ asset('js/select2Ajax.js') }}"></script>
<script src="{{ asset('js/selectBy.js') }}"></script>
<script src="{{ asset('global/vendor/select2/select2.min.js') }}"></script>
<script>
  $(function() {
    $('#bahan_id').select2(select2Ajax('Select', '{{ route("produkbahan.select2") }}', 1));
    $('#ukuran_id').select2(getData('Select', '{{ route("produkukuran.select2") }}', 1));
    $('#jenis_cetak').select2();
    $('#kebutuhan').select2();
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