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
        <h1 class="page-title">Order</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Kelola Order</a></li>
            <li class="breadcrumb-item active">Order</li>
        </ol>
    </div>
    <br><br>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-lg-12   col-xs-12">
                <!-- Panel Static Labels -->
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Form Order</h3>
                    </div>
                    <div class="panel-body container-fluid">
                        <div class="row" ng-controller="SearchItemCtrl">
                            <div class="col-md-3">
                                <label>Cari Produk <input ng-model="searchKeyword" class="form-control"></label>
                                <table class="table table-hover">@foreach($produk as $value)@endforeach
                                    <tr ng-repeat="produk in produks  | filter: searchKeyword | limitTo:10">
                                        <td>@{{produk.nama}} (@{{produk.bahan}} @{{produk.ukuran}}, @{{produk.sisi_cetak}})</td>
                                        <td><button class="btn btn-primary btn-xs" type="button" ng-click="addProdukTemp(produk, newproduktemp)"><span class="fas fa-plus-square" aria-hidden="true"></span></button></td>
                                    </tr>
                                </table>
                            </div>
                <div class="col-md-9">
                    <div class="row">
                        {!! Form::open(array('url' => 'order', 'class' => 'form-horizontal', 'data-parsley-validate' => '')) !!}
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="id_order" class="col-sm-4 control-label">ID Order</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" name="id_order" value="{{$kodeorder}}" readonly/>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="no_faktur" class="col-sm-4 control-label">No Faktur</label>
                                    <div class="col-sm-8">
                                    <input name="no_faktur" type="text" class="form-control" id="no_faktur" value="{{$kodefaktur}}" readonly/>
                                    </div>
                                </div>
                            </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label for="tanggal_order" class="col-sm-4 control-label">Tanggal Order</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="icon wb-calendar" aria-hidden="true"></i>
                                                    </span>
                                                    <input type="text" class="form-control datepicker" data-plugin="datepicker" data-date-format="dd-mm-yyyy" name="tanggal_order" id="tanggal_order" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="tanggal_selesai" class="col-sm-4 control-label">Tanggal Selesai</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="icon wb-calendar" aria-hidden="true"></i>
                                                    </span>
                                                    <input type="text" class="form-control datepicker DateFrom" data-plugin="datepicker" data-date-format="dd-mm-yyyy" name="tanggal_selesai" id="tanggal_selesai" readonly required>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="payment_type" class="col-sm-4 control-label">Pembayaran</label>
                                            <div class="col-sm-8">
                                                    <select id="select1" class="form-control" name="payment_type" onchange="setForm(this.value)">
                                                            <option value="DP">DP</option>
                                                            <option value="Lunas">Lunas</option>
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-4 control-label">No. Telepon</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="no_telfon" id="inputNotelf" required data-parsley-required-message="No. Telf harus diisi" />
                                            </div>
                                        </div>
                                        <br>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="comments" class="col-sm-4 control-label">Keterangan</label>
                                            <div class="col-sm-8">
                                                    {!! Form::text('desc', null, [
                                                        'class'                         => 'form-control',
                                                        'required',
                                                        'id'                            => 'inputDesc',
                                                        'data-parsley-required-message' => 'Keterangan harus diisi',
                                                        'data-parsley-trigger'          => 'change focusout',
                                                        'maxlength'                     => '120',
                                                        'data-parsley-maxlength'        => '120',
                                                        'data-parsley-type'             => 'text'
                                                    ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-4 control-label">Nama Pemesan</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="name" id="name" required data-parsley-required-message="Nama Pemesan harus diisi"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Harga</th>
                                        <th>Quantity</th>
                                        <th>Satuan</th>
                                        <th>Total</th>
                                        <th>Hapus</th>
                                    </tr>
                                    <tr ng-repeat="newproduktemp in produktemp">
                                        <td>@{{newproduktemp.id}}</td>
                                        <td>@{{newproduktemp.nama}}</td>
                                        <td>@{{newproduktemp.harga | currency: 'Rp.'}}</td>
                                        <td><input type="text" style="text-align:center" autocomplete="off" name="quantity" ng-change="updateSaleTemp(newproduktemp)" ng-model="newproduktemp.jumlah" size="2"></td>
                                        <td>Pcs</td>
                                        <td>@{{newproduktemp.harga * newproduktemp.jumlah | currency: 'Rp.'}}</td>
                                        <td><button class="btn btn-danger btn-xs" type="button" ng-click="removeSaleTemp(newproduktemp.id)"><span class="fas fa-trash" aria-hidden="true"></span></button></td>
                                    </tr>
                                </table>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="uang_masuk" class="col-sm-4 control-label">Bayar</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon">Rp.</div>
                                                    <input name="uang_masuk" type="text" class="form-control" id="add_payment" ng-model="add_payment" />
                                                    <input type="text" class="form-control" name="uang_masuk2" value="@{{sum(produktemp)}}" id="add_payment2" readonly  style="display: none;"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div>&nbsp;</div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total_cost" class="col-sm-4 control-label">Total</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="total_pembayaran" value="@{{sum(produktemp)}}" readonly />
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="amount_due" class="col-sm-4 control-label">Sisa</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="sisa_pembayaran" id="sisa_pembayaran" value="@{{add_payment - sum(produktemp)}}" readonly />
                                                <input type="text" class="form-control" name="sisa_pembayaran2" id="sisa_pembayaran2" value="@{{sum(produktemp) - sum(produktemp)}}" readonly style="display: none;"/>
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-primary btn-block">Order</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {!! Form::close() !!}

                            </div>
                        </div>
                        <!-- End Panel Floating Labels -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('script')
<script src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('global/vendor/formatter/jquery.formatter.js')}}"></script>
<script src="{{ asset('global/js/Plugin/formatter.js')}}"></script>

<script src="{{ asset('global/js/Plugin/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('global/js/moment.js') }}"></script>
<script type="text/javascript">
    setInputFilter(document.getElementById("inputNotelf"), function(value) {
      return /^\d*$/.test(value);
    });
    setInputFilter(document.getElementById("add_payment"), function(value) {
      return /^\d*$/.test(value);
    });
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

<script>
    $('.datepicker').datepicker();
    $("#tanggal_order").datepicker("setDate", new Date());
</script>
@stop
