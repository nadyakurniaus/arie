@extends('back.layouts-gudang.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/select2/select2.min.css') }}">
@stop

@section('body')

<div class="page">
    <div class="page-header">
      <h1 class="page-title">Ukuran Bahan Add Form</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Forms</a></li>
        <li class="breadcrumb-item active">Ukuran Bahan</li>
      </ol>
      <div class="page-header-actions">
        <a href="{{ route('ukuranbahan.index') }}" class="btn btn-md btn-icon btn-outline btn-warning btn-round"
            data-toggle="tooltip" data-original-title="Go back to role index">
            <i class="icon wb-arrow-left" aria-hidden="true"></i> &nbsp; Go Back
        </a>
        <button type="submit" class="btn btn-md btn-icon btn-success btn-round" data-toggle="tooltip"
            data-original-title="Save">
            <i class="icon wb-check" aria-hidden="true"></i> &nbsp; Save
        </button>
    </div>
    </div>
    
    <div class="page-content container-fluid">
      <div class="row">
        <div class="col-lg-6 col-xs-12">
          <!-- Panel Static Labels -->
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">Ukuran Bahan Add Form</h3>
            </div>
            <div class="panel-body container-fluid">
              <form action="{{ route('ukuranbahan.store') }}" method="POST" autocomplete="off">
                  @csrf
                
                <div class="form-group form-material" data-plugin="formMaterial"> 
                  <input type="text" class="form-control" id="inputText" name="nama" placeholder="Ukuran Bahan Baku"
                  />
                </div>
                <div class="form-group form-material" data-plugin="formMaterial">
                  <label class="label" for="inputText">Bahan baku</label>
                  <select name="bahan_id" id="bahan_id" class="form-control select2">
                  </select>
              </div>
              
                <div class="form-group form-material" data-plugin="formMaterial"> 
                  <input type="text" class="form-control" id="inputText" name="stok" placeholder="Stok"
                  />
                </div>
                <div class="form-group form-material" data-plugin="formMaterial"> 
                  <input type="text" class="form-control" id="inputText" name="satuan" placeholder="Satuan"
                  />
                </div>
                
                    <div>
                    <span class="input-group-btn">
                      <button class="btn btn-info" type="submit" name="simpan">Tambah Ukuran Bahan</button>
                    </span>
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
<script>
  $(function(){
      $('#bahan_id').select2(select2Ajax('Select', '{{ route("bahan.select2") }}', 1));
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
