@extends('back.layouts-setting.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/dropify/dropify.min.css') }}">
@stop

@section('body')

<div class="page">
<form action="{{ route('setting.update', $design->id)}}" method="POST" autocomplete="off" enctype="multipart/form-data">
    <input name="_method" type="hidden" value="PATCH">
    @csrf
    <div class="page-header">
        <h1 class="page-title">Tambah Desain Order</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/bagsetting">Bagian Setting</a></li>
            <li class="breadcrumb-item"><a href="/setting">Kelola Desain Order</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
        <div class="page-header-actions">
            <a href="{{ route('setting.index') }}" class="btn btn-md btn-icon btn-outline btn-warning btn-round"
                data-toggle="tooltip" data-original-title="Kembali">
                <i class="icon wb-arrow-left" aria-hidden="true"></i> &nbsp; Kembali
            </a>
            <button type="submit" class="btn btn-md btn-icon btn-primary btn-round" data-toggle="tooltip"
            data-original-title="Simpan Design">
            <i class="icon wb-check" aria-hidden="true"></i> &nbsp; Simpan
        </button>
        </div>
    </div>
    <div class="page-content">
            <div class="row">
                    <div class="col-lg-10 offset-lg-1 col-md-12 col-xs-12 col-12">
                        <!-- Panel Static Labels -->
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">Form Ubah Order</h3>
                            </div>
                            <div class="panel-body container-fluid">
                                <div class="col-md-6">
                                    <div class="form-group form-material floating" data-plugin="formMaterial">
                                    <input type="text" class="form-control" id="inputText" name="kode_design" value="{{ $kode_design }}" readonly/>
                                        <label class="floating-label" for="name">ID Design</label>
                                    </div>
                                    <div class="form-group form-material floating" data-plugin="formMaterial">
                                    <input type="text" class="form-control" id="inputText" name="name" value="{{ $bb->kode_produksi }}" readonly/>
                                        <label class="floating-label" for="name">ID Produksi</label>
                                    </div>
                                    <div class="form-group form-material floating" data-plugin="formMaterial">
                                        <input type="text" class="form-control" id="inputText" name="name" value="{{ $bb->name }}" readonly/>
                                    <label class="floating-label" for="textarea">Nama Pemesan</label>
                                </div>
                                <div class="form-group form-material floating" data-plugin="formMaterial">
                                    <input type="text" class="form-control" id="inputText" name="name" value="{{ $bb->namaproduk }}" readonly/>
                                <label class="floating-label" for="textarea">Produk</label>
                            </div>
                                </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-material floating" data-plugin="formMaterial">
                                            <div class="example-wrap">
                                                <h4 class="example-title">Design</h4>
                                                <div class="example">
                                                  <input type="file" name="design" class="dropify" id="input-file-max-fs" data-plugin="dropify" data-max-file-size="2M"
                                                  />
                                                </div>
                                              </div>
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

@include('back.layouts.update-modal')
@stop
@section('script')

<script src="{{ asset('global/js/Plugin/material.js') }}"></script>
<script src="{{ asset('global/vendor/dropify/dropify.min.js') }}"></script>
<script type="text/javascript">
 $('.dropify').dropify();
</script>
@if(session('message'))
<script>
    toastr["success"]("{{ session('message') }}", "Success");

</script>
@endif
@stop
