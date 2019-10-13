@extends('back.layouts.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/select2/select2.min.css') }}">
@stop

@section('body')

<div class="page">
  <div class="page-header">
    <h1 class="page-title">Produk</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/bagsetting">Admin</a></li>
            <li class="breadcrumb-item"><a href="/setting">Kelola Produk</a></li>
              <li class="breadcrumb-item"><a href="/setting">Produk</a></li>
            <li class="breadcrumb-item active">Ubah</li>
    </ol>
    <div class="page-header-actions">
        <form action="{{ route('product.update', $produk->id) }}" method="POST" autocomplete="off">
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
          <h3 class="panel-title">Ubah Produk "{{ $produk->nama }}"</h3>
          </div>
          <div class="panel-body container-fluid">
              <div class="form-group form-material" data-plugin="formMaterial">
                  <label class="label" for="inputText">Nama Produk</label>
                <input type="text" class="form-control" id="inputText" name="nama" value="{{ $produk->nama }}" />
              </div>
              <div class="form-group form-material" data-plugin="formMaterial">
                <label class="label" for="inputText">Bahan Baku</label>
                <select name="id_bahan" id="bahan_id" class="form-control select2">
                        @foreach ($produk as $tag)
                            <option value="{{ $tag }}" selected="selected">{{ $produk->ukuran->bahan->nama }}</option>
                        @endforeach
                </select>
              </div>
              <div class="form-group form-material" data-plugin="formMaterial">
                <label class="label" for="inputText">Ukuran Bahan</label>
                <select name="id_ukuran" id="ukuran_id" class="form-control select2">
                        @foreach ($produk as $tag)
                            <option value="{{ $tag }}" selected="selected">{{ $produk->ukuran->nama }}</option>
                        @endforeach
                </select>
              </div>
              <div class="form-group form-material" data-plugin="formMaterial">
                <label class="label" for="inputText">Kebutuhan</label>
                <select name="kebutuhan" id="kebutuhan" class="form-control select2 js-example-placeholder-single">
                    <option></option>

                  <option value="Identitas Perusahaan">Identitas Perusahaan</option>
                  <option value="Media Promosi">Media Promosi</option>
                  <option value="Kartu">Kartu</option>
                </select>
              </div>
              <div class="form-group form-material" data-plugin="formMaterial">
                  <label class="label" for="inputText">Jenis Cetak</label>
                <select name="jenis_cetak" id="jenis_cetak" class="form-control select2 js-example-placeholder-single2">
                    <option></option>

                  <option value="Digital Printing">Digital Printing</option>
                  <option value="Offset">Offset</option>
                </select>
              </div>
              <div class="form-group form-material" data-plugin="formMaterial">
                <label class="label" for="inputText">Sisi Cetak</label>
              <input type="text" class="form-control" id="inputText" name="sisi_cetak" value="{{ $produk->sisi_cetak }}" />
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
    $(".js-example-placeholder-single").select2({
    placeholder: "{{$produk->kebutuhan}}",
    allowClear: true
    });
    $(".js-example-placeholder-single2").select2({
    placeholder: "{{$produk->jenis_cetak}}",
    allowClear: true
    })
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