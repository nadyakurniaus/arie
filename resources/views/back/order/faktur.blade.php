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
          #headerFaktur1 {
            display: none;
          }
        }</style>
@stop

@section('body')

<div class="page">
    <div class="page-header" id="headerFaktur">
        <h1 class="page-title">Faktur Order</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Forms</a></li>
            <li class="breadcrumb-item active">Faktur Order</li>
        </ol>
        <div class="page-header-actions" id="headerFaktur1">
            <a href="{{ route('order.index') }}" class="btn btn-md btn-icon btn-outline btn-warning btn-round" data-toggle="tooltip" data-original-title="Kembali ke Order">
                <i class="icon wb-arrow-left" aria-hidden="true"></i> &nbsp; Kembali
            </a>
            <button type="button" class="btn btn-animate btn-animate-side btn-primary  btn-round" data-toggle="tooltip" data-original-title="Cetak Faktur"
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
                  <div class="col-xs-12 col-lg-3 offset-lg-6 text-xs-right">
                    <h4>Faktur Info</h4>
                    <p>
                    <a class="font-size-20" href="javascript:void(0)">{{ $penjualan->no_faktur }}</a>
                      <br>
                        <span>Karawang, {{$penjualan->tanggal_order}}</span>
                      <br> Yth :
                      <span class="font-size-16">{{ $penjualan->name}}</span>
                      <br> No. Telepon : {{ $penjualan->no_telfon}}
                    </p>
                    <br>
                    <br>
                  </div>
                </div>
                <div class="page-invoice-table table-responsive">
                  <table class="table table-hover text-xs-right">
                    <thead>
                      <tr>

                        <th class="text-xs-center">Produk</th>
                        <th class="text-xs-center">Bahan Baku</th>
                        <th class="text-xs-center">Ukuran</th>
                        <th class="text-xs-center">Quantity</th>
                        <th class="text-xs-center">Satuan</th>
                        <th class="text-xs-center">Harga</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($orderItem as $value)
                      <tr>
                        <td class="text-xs-center">
                            {{ $value->item->nama}}
                        </td>
                        <td class="text-xs-center">
                            {{ $value->item->bahan->nama}}
                        </td>
                        <td class="text-xs-center">
                            {{ $value->item->ukuran->nama}}
                        </td>
                        <td class="text-xs-center">
                            {{ $value->jumlah}}
                        </td>
                        <td class="text-xs-center">
                            Pcs
                        </td>
                        <td class="text-xs-center">
                            {{ $value->harga}}
                        </td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="text-xs-right clearfix">
                  <div class="pull-xs-right">
                    <p>Sub - Total Pembayaran:
                    <span>Rp.{{ $pembayaran->total_pembayaran }},-</span>
                    </p>
                    <p>Pembayaran Masuk:
                    <span>Rp. {{ $pembayaran->uang_masuk }},-</span>
                    </p>
                    <p class="page-invoice-amount">Sisa Pembayaran:
                    <span>Rp. {{ $pembayaran->sisa_pembayaran }},- / {{ $pembayaran->tipe_pembayaran }}</span>
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
<script>
    (function(document, window, $) {
        'use strict';
        var Site = window.Site;
        $(document).ready(function() {
        Site.run();
        });
    })(document, window, jQuery);
    $('.datepicker').datepicker();
</script>
@stop
