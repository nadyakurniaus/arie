@extends('back.layouts.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.css') }}">
{!! Html::script('js/angular.min.js', array('type' => 'text/javascript')) !!}
{!! Html::script('js/produk.js', array('type' => 'text/javascript')) !!}
<style>
@media print {
  #footerCv{
    display:none;
  }
  #headerFaktur {
    display: none;
  }
}</style>
@stop

@section('body')

<div class="page">
    <div class="page-header" id="headerFaktur">
        <h1 class="page-title">Price List Produk</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Kelola Produk</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Price List Produk</a></li>
            <li class="breadcrumb-item active">Laporan</li>
        </ol>
        <div class="page-header-actions">
            <a href="{{ route('order.index') }}" class="btn btn-md btn-icon btn-outline btn-warning btn-round" id="buttonKembali" data-toggle="tooltip" data-original-title="Kembali ke Order">
                <i class="icon wb-arrow-left" aria-hidden="true"></i> &nbsp; Kembali
            </a>
            <button type="button" class="btn btn-animate btn-animate-side btn-primary  btn-round" id="printPageButton" data-toggle="tooltip" data-original-title="Cetak Faktur"
            onclick="javascript:window.print();">
              <span><i class="icon wb-print" aria-hidden="true"></i> Print</span>
            </button>
        </div>
    </div>
    <div class="page-content">
            <!-- Panel -->
            <div class="panel">
              <div class="panel-body container-fluid">
                <div class="row">
                  <div class="col-lg-3 col-xs-12">
                    <h4>
                      <img class="m-r-10" src="global/assets/images/logo-blue.png" alt="...">Percetakan Arie</h4>
                    <address>
                      Jl. A.R. Hakim 107 Karawang Barat
                      <br>
                      <abbr title="Mail">E-mail:</abbr>&nbsp;&nbsp;percetakanarie@gmail.com
                      <br>
                      <abbr title="Phone">No. Telepon:</abbr>&nbsp;&nbsp;0267 402582
                      <br>
                    </address>
                  </div>
                </div>
                <div class="row">
                <h4 align="center"><h4 align="center">Laporan Price List - {!!\Carbon\Carbon::now()->format('d/m/Y')!!} </h4></h4>
                </div>
                <strong>Jenis Cetak :</strong> Offset
                <div class="page-invoice-table table-responsive">
                  <table class="table table-hover text-xs-right" id="myTable">
                    <thead>
                      <tr>
                        <th class="text-xs-center">No</th>
                        <th class="text-xs-center">ID Produk</th>
                        <th class="text-xs-center">Nama Produk</th>
                        <th class="text-xs-center">Bahan Baku</th>
                        <th class="text-xs-center">Ukuran</th>
                        <th class="text-xs-center">Kebutuhan</th>
                        <th class="text-xs-center">Sisi Cetak</th>
                        <th class="text-xs-center">Quantity</th>
                        <th class="text-xs-center">Satuan</th>
                        <th class="text-xs-center">Harga</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach($data1 as $value)
                      <tr>
                        <td class="text-xs-center" >
                            {{$value->id}}
                        </td>
                        <td class="text-xs-center">
                            {{$value->idProduk}}
                        </td>
                        <td class="text-xs-center" >
                            {{$value->namaprod}}
                        </td>
                        <td class="text-xs-center" >
                            {{$value->bahan->nama}}
                        </td>
                        <td class="text-xs-center" >
                            {{$value->ukuran->nama}}
                        </td>
                        <td class="text-xs-center" >
                          {{$value->kebutuhan}}
                      </td>
                      <td class="text-xs-center" >
                          {{$value->sisi_cetak}}
                    </td>
                    <td class="text-xs-center" >
                        {{$value->quantity}}
                  </td>
                  <td class="text-xs-center" >
                        Pcs
                  </td>
                  <td class="text-xs-center" >
                      {{$value->harga}}
                </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <br><br><br>
                <strong>Jenis Cetak :</strong> Digital Printing
                <div class="page-invoice-table table-responsive">
                  <table class="table table-hover text-xs-right" id="MyTable">
                    <thead>
                      <tr>
                        <th class="text-xs-center">No</th>
                        <th class="text-xs-center">ID Produk</th>
                        <th class="text-xs-center">Nama Produk</th>
                        <th class="text-xs-center">Bahan Baku</th>
                        <th class="text-xs-center">Ukuran</th>
                        <th class="text-xs-center">Kebutuhan</th>
                        <th class="text-xs-center">Sisi Cetak</th>
                        <th class="text-xs-center">Quantity</th>
                        <th class="text-xs-center">Harga</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($data2 as $value)
                      <tr>
                          <td class="text-xs-center">
                              {{$value->id}}
                          </td>
                          <td class="text-xs-center">
                              {{$value->idProduk}}
                          </td>
                          <td class="text-xs-center">
                              {{$value->nama}}
                          </td>
                          <td class="text-xs-center">
                              {{$value->bahan->nama}}
                          </td>
                          <td class="text-xs-center">
                              {{$value->ukuran->nama}}
                          </td>
                          <td class="text-xs-center">
                            {{$value->kebutuhan}}
                        </td>
                        <td class="text-xs-center">
                            {{$value->sisi_cetak}}
                      </td>
                      <td class="text-xs-center">
                          {{$value->quantity}}
                    </td>
                    <td class="text-xs-center">
                        {{$value->harga}}
                  </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <br>
                <br>
                <br>
                <br>
                <div class="text-xs-right clearfix">
                  <div class="pull-xs-right">
                    <p>Tertanda:
                    <span>Admin</span>
                    </p>
                    <br><br>
                    <p class="page-invoice-amount">(_______________)
                    </p>
                  </div>
                </div>

              </div>
            </div>
            <!-- End Panel -->
          </div>
</div>

@stop

@section('script')
<script src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('global/js/Plugin/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('global/js/moment.js') }}"></script>
<script type="text/javascript">

</script>
@stop
