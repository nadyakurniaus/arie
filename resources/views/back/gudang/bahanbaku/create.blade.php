@extends('back.layouts-gudang.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{asset('global/vendor/bootstrap-select/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-sweetalert/sweetalert.css') }}">
<style>
  .select2,.select2-container {
      width: 100% !important;
  }
</style>
@stop

@section('body')

<div class="page">
    <form action="{{ route('bahanbaku.store') }}" method="POST" autocomplete="off" data-parsley-validate="">
        @csrf
    <div class="page-header">
      <h1 class="page-title">Tambah Bahan Baku</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Bagian Gudang</a></li>
             <li class="breadcrumb-item"><a href="javascript:void(0)">Kelola Bahan Baku</a></li>
             <li class="breadcrumb-item"><a href="javascript:void(0)">Bahan Baku</a></li>
            <li class="breadcrumb-item active">Tambah</li>
      </ol>

      <div class="page-header-actions">
            <form action="{{ route('bahanbaku.store') }}" method="POST" autocomplete="off">
                    @csrf
        <a href="{{ route('bahanbaku.index') }}" class="btn btn-md btn-icon btn-outline btn-warning btn-round"
            data-toggle="tooltip" data-original-title="Kembali ke list bahan baku">
            <i class="icon wb-arrow-left" aria-hidden="true"></i> &nbsp; Kembali
        </a>
        <button type="submit" class="btn btn-md btn-icon btn-success btn-round btn-simpan" data-toggle="tooltip"
            data-original-title="Simpan bahan baku">
            <i class="icon wb-check" aria-hidden="true"></i> &nbsp; Simpan
        </button>

    </div>
    </div>

    <div class="page-content container-fluid">
      <div class="row">
        <div class="col-lg-6  col-xs-12">
          <!-- Panel Static Labels -->
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">Bahan Baku </h3>
            </div>
            <div class="panel-body container-fluid">

                <div class="form-group form-material" data-plugin="formMaterial">
                <input type="text" class="form-control"  name="idBB" value="{{$kodebahan}}"
                   readonly />
                  </div>
                <div class="form-group form-material" data-plugin="formMaterial">
                    {!! Form::text('nama', null, [
                      'class'                         => 'form-control',
                      'placeholder'                   => 'Nama Bahan Baku',
                      'required',
                      'id'                            => 'inputNama',
                      'data-parsley-required-message' => 'Bahan Baku harus diisi',
                      'data-parsley-trigger'          => 'change focusout',
                      'maxlength'                     => '30',
                      'data-parsley-maxlength'        => '30',
                      'data-parsley-type'             => 'text'
                  ]) !!}
                </div>
                <div class="form-group form-material" data-plugin="formMaterial">
                  <select name="jenis" class="form-control" data-plugin="select2">
                    <optgroup label="Jenis Bahan">
                      <option value="">- Pilih Salah Satu -</option>
                      <option value="Kertas">Kertas</option>
                      <option value="Amplop">Amplop</option>
                      <option value="Kain">Kain</option>
                      <option value="Map">Map</option>
                      <option value="Stiker">Stiker</option>
                         <option value="Stiker">Pin</option>
                            <option value="Stiker">Karcis</option>
                               <option value="Stiker">ID Card</option>
                    </optgroup>
                  </select>
                </div>
            </div>
          </div>
          <!-- End Panel Floating Labels -->
        </div>
        <div class="col-lg-6 col-xs-12">
          <!-- Panel Static Labels -->
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">Ukuran Bahan Baku</h3>
            </div>
            <div class="panel-body container-fluid">
              <form action="{{ route('ukuranbahan.store') }}" method="POST" autocomplete="off">
                  @csrf
                  <div class="form-group form-material" data-plugin="formMaterial">
                      <input type="text" class="form-control"  name="idUkuran" value="{{$kodeukuran}}"
                         readonly />
                        </div>
                <div class="form-group form-material" data-plugin="formMaterial">
                    {!! Form::text('namaukuran', null, [
                      'class'                         => 'form-control',
                      'placeholder'                   => 'Ukuran Bahan Baku',
                      'required',
                      'id'                            => 'inputUkuran',
                      'data-parsley-required-message' => 'Ukuran Bahan harus diisi',
                      'data-parsley-trigger'          => 'change focusout',
                      'maxlength'                     => '30',
                      'data-parsley-maxlength'        => '30',
                      'data-parsley-type'             => 'text'
                  ]) !!}
                </div>
                <div class="form-group form-material" data-plugin="formMaterial">
                    <div class="input-group input-group-icon">
                        <input type="text" class="form-control" placeholder="Stok" name="stok">
                        <span class="input-group-addon">
                        <span class="icon" aria-hidden="true">pcs</span>
                        </span>
                    </div>
                    </div>
                </div>
                <div class="form-group form-material" data-plugin="formMaterial">
                    {!! Form::hidden('satuan', 'pcs', [
                      'class'                         => 'form-control',
                      'placeholder'                   => 'Satuan',
                      'required',
                      'id'                            => 'inputSatuan',
                      'data-parsley-required-message' => 'Stok harus diisi',
                      'data-parsley-trigger'          => 'change focusout',
                      'maxlength'                     => '10',
                      'data-parsley-maxlength'        => '10',
                      'data-parsley-type'             => 'hidden'
                  ]) !!}
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
<script src="{{ asset('global/vendor/select2/select2.min.js') }}"></script>
<script src="{{ asset('global/js/Plugin/bootstrap-select.js')}}"></script>
<script src="{{ asset('global/vendor/bootstrap-sweetalert/sweetalert.js')}}"></script>
<script type="text/javascript">
    setInputFilter(document.getElementById("inputStok"), function(value) {
      return /^\d*$/.test(value);
    });
</script>
@if($errors->any())
  <script>
      toastr["error"]("@foreach($errors->all() as $x) {{ $x }} <br> @endforeach", "Error");
  </script>
@endif
@if(session('error'))
    <script>
        toastr["error"]("{{ session('error') }}", "Info!");
    </script>
@endif
@if(session('message'))
    <script>
        toastr["info"]("{{ session('message') }}", "Berhasil!");
    </script>
@endif
@stop
