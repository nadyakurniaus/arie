@extends('back.layouts-finance.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/select2/select2.min.css') }}">
@stop

@section('body')

<div class="page">
  <div class="page-header">
    <h1 class="page-title">Tambah Pelunasan Pembayaran</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/finance">Bagian Finance</a></li>
        <li class="breadcrumb-item"><a href="/finance">Kelola Pembayaran</a></li>
      <li class="breadcrumb-item active">Tambah Pelunasan</li>
    </ol>
    <div class="page-header-actions">
        <form action="{{ route('pembayaran.update', $pembayaran->id) }}" method="POST" autocomplete="off">
                <input name="_method" type="hidden" value="PATCH">
            @csrf
      <a href="{{ route('pembayaran.index') }}" class="btn btn-md btn-icon btn-outline btn-warning btn-round" data-toggle="tooltip" data-original-title="Go back to role index">
        <i class="icon wb-arrow-left" aria-hidden="true"></i> &nbsp; Kembali
      </a>
      <button type="submit" class="btn btn-md btn-icon btn-primary btn-round" data-toggle="tooltip" data-original-title="Save">
        <i class="icon wb-check" aria-hidden="true"></i> &nbsp; Simpan
      </button>
    </div>
  </div>

  <div class="page-content container-fluid">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 col-xs-12">
        <!-- Panel Static Labels -->
        <div class="panel">
          <div class="panel-heading">
          <h3 class="panel-title">Pembayaran untuk {{ $pembayaran->no_faktur }} - {{$pembayaran->name}}</h3>

          <div class="panel-body container-fluid">
              <div class="row">
                  <div class="col-md-6">
              <div class="form-group form-material" data-plugin="formMaterial">
                  <label class="label" for="inputText">Nama Pemesan</label>
                <input type="text" class="form-control" id="inputText" name="name" value="{{ $pembayaran->name }}" readonly/>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group form-material" data-plugin="formMaterial">
                    <label class="label" for="inputText">Status</label>
                    <select name="tipe_pembayaran" id="tipe_pembayaran" class="form-control select2">
                            <option value="Lunas" selected="selected">Lunas</option>
                            <option value="DP">DP</option>
                </select>
                  </div>
                </div>
                </div>
              <div class="row">
              <div class="col-md-6">
              <div class="form-group form-material" data-plugin="formMaterial">
                <label class="label" for="inputText">Tanggal Order</label>
                <input type="text" class="form-control moment" id="inputText" name="tanggal_order" id="tanggal_order" value="{{ $pembayaran->tanggal_order }}" readonly/>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group form-material" data-plugin="formMaterial">
                <label class="label" for="inputText">Tanggal Selesai</label>
                <input type="text" class="form-control" id="inputText" name="tanggal_selesai" id="tanggal_selesai" value="{{ $pembayaran->tanggal_selesai }}" readonly/>
              </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                    <div class="form-group form-material" data-plugin="formMaterial">
                            <label class="label" for="inputText">Total Pembayaran</label>
                            <input type="text" class="form-control" id="inputText" name="total_pembayaran" value="{{ $penjualan->total_pembayaran }}" readonly/>
                          </div>
            </div>
            <div class="col-md-6">
              <div class="form-group form-material" data-plugin="formMaterial">
                <label class="label" for="inputText">Uang Masuk</label>
                <input type="text" class="form-control" id="inputText" name="uang_masuk" value="{{ $penjualan->uang_masuk }}" readonly/>
              </div>
            </div>
            </div>
              <div class="row">
                  <div class="col-md-6">
              <div class="form-group form-material" data-plugin="formMaterial">
                <label class="label" for="inputText">Sisa Pembayaran</label>
                <input type="text" class="form-control" id="inputText" name="sisa_pembayaran" value="{{ $penjualan->sisa_pembayaran }}" readonly/>
              </div >
            </div>
              <div class="col-md-6">
                    <label class="label" for="inputText"><strong>Detail Order</strong></label>
              <table class="table table-striped" data-tablesaw-mode="swipe"
              data-tablesaw-minimap style="width:100%;">
                <thead>
                  <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Quantity</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($detail as $value)
                    <tr>
                      <td>{{ $value->produk->nama }}</td>
                      <td>{{ $value->harga }}</td>
                      <td>{{ $value->jumlah }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            </div>
              <div class="form-group form-material" data-plugin="formMaterial">
                <label class="label" for="inputText">Bayar</label>
              <input type="text" class="form-control" id="inputText" name="bayar" value="{{abs($penjualan->sisa_pembayaran) }}" readonly/>
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
<script src="{{ asset('global/js/moment.js') }}"></script>
<script src="{{ asset('global/vendor/select2/select2.min.js') }}"></script>
<script>
  $(function() {
    var moment = require('moment');
    $('#tipe_pembayaran').select2();
    $('#tanggal_order').moment().format('DD MMMM, YYYY');
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
