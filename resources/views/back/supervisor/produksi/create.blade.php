@extends('back.layouts-supervisor.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/select2/select2.min.css') }}">
@stop

@section('body')

<div class="page">
  <div class="page-header">
    <h1 class="page-title">Tambah Produksi</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/admin">Home</a></li>
      <li class="breadcrumb-item"><a href="javascript:void(0)">Forms</a></li>
      <li class="breadcrumb-item active">Produksi</li>
    </ol>
    <div class="page-header-actions">
      <a href="{{ route('produk.index') }}" class="btn btn-md btn-icon btn-outline btn-warning btn-round" data-toggle="tooltip" data-original-title="Go back to role index">
        <i class="icon wb-arrow-left" aria-hidden="true"></i> &nbsp; Kembali
      </a>
      <button type="submit" class="btn btn-md btn-icon btn-success btn-round" data-toggle="tooltip" data-original-title="Save">
        <i class="icon wb-check" aria-hidden="true"></i> &nbsp; Save
      </button>
    </div>
  </div>

  <div class="page-content container-fluid">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 col-xs-12">
        <!-- Panel Static Labels -->
        <div class="panel">
          <div class="panel-heading">
            <h3 class="panel-title">Tambah Produksi</h3>
          </div>
          <div class="panel-body container-fluid">
            @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
            <form action="{{ route('produksi.store') }}" method="POST" autocomplete="off">
              @csrf

              <div class="form-group form-material" data-plugin="formMaterial">
                <input type="text" class="form-control" id="inputText" name="kode_produksi" value="{{$nama}}" placeholder="Kode Produksi" />
              </div>
              <div class="form-group form-material" data-plugin="formMaterial">
                <label class="label" for="inputText">ID Order</label>
                <select name="id_order" id="order_id" class="form-control select2">
                </select>
              </div>
              <div class="form-group form-material" data-plugin="formMaterial">
                <input type="text" class="form-control" id="inputText" name="keterangan" placeholder="Keterangan" />
              </div>
              <div class="form-group form-material" data-plugin="formMaterial">
                <label class="label" for="inputText">Bahan Baku</label>
                <select name="id_bahan" id="bahan_id" class="form-control select2">
                </select>
              </div>
              <div class="form-group form-material" data-plugin="formMaterial">
                <label class="label" for="inputText">Ukuran Bahan</label>
                <select name="id_ukuran" id="ukuran_id" class="form-control select2">
                </select>
              </div>
              <div class="form-group form-material" data-plugin="formMaterial">
                <input type="text" class="form-control" id="inputText" name="qty" placeholder="Qty" />
              </div>
              <div class="form-group form-material" data-plugin="formMaterial">
                <label class="label" for="inputText">Satuan</label>
                <select name="satuan" id="satuan" class="form-control select2">
                  <option value="box">Box</option>
                  <option value="rim">Rim</option>
                  <option value="pcs">Pcs</option>
                </select>
              </div>
              <div>
                <span class="input-group-btn">
                  <button class="btn btn-info" type="submit" name="simpan">Tambah Produksi</button>
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
  $(function() {
    $('#order_id').select2(getNoOrder('Select', '{{ route("orderid.select2") }}', 1));
    $('#ukuran_id').select2(select2Ajax('Select', '{{ route("produkukuran.select2") }}', 1));
    $('#bahan_id').select2(select2Ajax('Select', '{{ route("produkbahan.select2") }}', 1));
    $('#satuan').select2();
  })
</script>
@if($errors->any())
<script>
  toastr["error"]("@foreach($errors->all() as $x) {{ $x }} <br> @endforeach", "Error");
</script>
@endif
@if(session('message'))
<script>
  toastr["success"]("{{ session('message') }}", "Success");
</script>
@endif
@stop