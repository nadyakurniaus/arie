@extends('back.layouts.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.min.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.css') }}">
<style>
        .print-only{
        display: none;
    }

    @media print {

        .print-only{
            display: block;
        }
}
        </style>
@stop

@section('body')
<!-- Page -->
<div class="page">
    <div class="page-header">
        <h1 class="page-title">Rekapitulasi Order</h1>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Kelola Order</a></li>
            <li class="breadcrumb-item active">Rekapitulasi Order</li>
        </ol>
        <div class="page-header-actions">
        </div>
    </div>
    <div class="page-content">
        <div class="panel">
                <header class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-15">
                                    <div class="form-group">
                                        <div class="col-sm-8">
                                                <div class="input-daterange" data-plugin="datepicker">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                            <i class="icon wb-calendar" aria-hidden="true"></i>
                                                            </span>
                                                            <input type="text" class="form-control datepicker" name="start" id="start" readonly/>
                                                        </div>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">to</span>
                                                            <input type="text" class="form-control datepicker" name="end" id="end" value="" readonly/>
                                                        </div>
                                                    </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <button id="searchData" class="btn btn-outline btn-primary" type="button">
                                                <i class="icon wb-search" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                        <div class="col-sm-2">
                                                <button id="print" class="btn btn-outline btn-primary" type="button">
                                                    <i class="icon wb-print" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
            <header class="panel-heading">
                <div class="panel-actions">
                </div>
                <h3 class="panel-title"></h3>
            </header>
            <div class="printableArea">
            <div class="panel-body">
                <div class="row print-only" id="headerFak">
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
                    <header class="panel-heading" align="center">
                            <h4 id="judul"></h4>
                    </header>
                <table class="table table-hover table-user table-striped w-full">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Faktur</th>
                            <th>Nama Pemesan</th>
                            <th>No Telepon</th>
                            <th>Tanggal Order</th>
                            <th>Status</th>
                            <th>Produk</th>
                            <th>Desc</th>
                            <th>Harga</th>
                            <th>Total Pembayaran</th>
                            <th>Uang Masuk</th>
                            <th>Sisa Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
                <div class="text-xs-right clearfix print-only row">
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
    </div>
</div>
</div>
<div class="modal fade modal-fade-in-scale-up" id="exampleNiftyFadeScale1" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"> Detail Item</h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-price table-striped w-full">
                    <thead>
                        <tr>
                            <th>Pembayaran Ke-</th>
                            <th>Uang Masuk</th>
                            <th>Total yang harus dibayar</th>
                            <th>Sisa Pembayaran</th>
                        </tr>
                    </thead>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- modal start -->
<div class="modal fade modal-fade-in-scale-up" id="exampleNiftyFadeScale" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"> Detail Item</h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-detail table-striped w-full">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Id Produk</th>
                            <th>Harga</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- modal end -->

@include('back.layouts.modal')
@stop
@section('script')
<script src="{{ asset('global/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>
<script src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('global/js/Plugin/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('global/js/moment.js') }}"></script>
<script src="{{ asset('global/js/jquery.printarea.js') }}"></script>
<script type="text/javascript">
    $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            todayBtn: "linked",
            language: "id",
        }).datepicker("setDate", new Date());
        $('#end').datepicker({
            format: 'dd-mm-yyyy',
            todayBtn: "linked",
            language: "id",
        }).datepicker("setDate", new Date());
    $(function() {
        var dt = $('.table-user').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            paging: false,
            info: false,
            exportOptions: {
                    columns: [0,1,2,3,4,5,6,7, ':hidden']

                },
            ajax: {
                url: '{{ route("order.dt") }}',
                    data: function(d) {
                            d.from = $('input[name=start]').val();
                            d.to = $('input[name=end]').val();
                        }
                },

            columns: [
                {
                    data: 'DT_RowIndex',
                    orderable: false, searchable: false
                 },
                {
                    data: 'no_faktur'
                },
                {
                    data: 'name'
                },
                {
                    data: 'no_telfon'
                },
                {
                    data: 'tanggal_order',
                    render: function(data, type, row) {
                        return moment(data).format('DD MMMM, YYYY');
                    }
                },
                {
                    data: 'tipe_pembayaran'
                },
                {
                    data: 'nama_produk'
                },
                {
                    data: 'desc'
                },
                {
                    data: 'harga'
                },
                {
                    data: 'total_pembayaran'
                },
                {
                    data: 'uang_masuk'
                },
                {
                    data: 'sisa_pembayaran'
                },
                {
                    data: 'id',
                    render: function(data) {
                        return '<button class="btn btn-xs btn-icon btn-warning btn-round" data-target="#exampleNiftyFadeScale" data-toggle="modal"><i class="icon wb-search" aria-hidden="true"></i></button>'+
                        '<button class="btn btn-xs btn-icon btn-success btn-round" data-target="#exampleNiftyFadeScale1" data-toggle="modal"><i class="icon fa-dollar" aria-hidden="true">$</i></button>'
                    }
                }

            ],
        })
        $('.input-daterange').datepicker({
                 autoclose: true,
                 todayHighlight: true
            });

        $('#searchData').on('click', function() {
            dt.draw();
            $('#judul').html('Laporan Rekapitulasi Order Tanggal ' + $('#start').val() +' / '+  $('#end').val());
        });
        $("#print").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.printableArea").printArea(options);
        });
        $('.table-user').on('draw.dt', function() {
            $('.btn-warning').on('click', function(e) {
                var data = dt.row($(this).parents('tr')).data();
                if ($.fn.DataTable.isDataTable('.table-detail')) {
                    $('.table-detail').DataTable().destroy();
                }
                $('.table-detail tbody').empty();
                var dtDetail = $('.table-detail').DataTable({
                    searching: false,
                    paging: false,
                    info: false,
                    processing: true,
                    serverSide: true,
                    ajax: ({
                        url: '{{ route("order.dtDetail") }}',
                        type: "POST",
                        data: {
                            'id': data.id
                        },
                        dataType: "JSON",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }),
                    columns: [{
                            data: 'DT_RowIndex'
                        },
                        {
                            data: 'nama_produk'
                        },
                        {
                            data: 'harga',
                            render: function(data){
                                return 'Rp. '+data;
                            }
                        },
                        {
                            data: 'jumlah',
                        }

                    ],
                })
            });
        });
        $('.table-user').on('draw.dt', function() {
            $('.btn-success').on('click', function(e) {
                var data = dt.row($(this).parents('tr')).data();
                if ($.fn.DataTable.isDataTable('.table-price')) {
                    $('.table-price').DataTable().destroy();
                }
                $('.table-price tbody').empty();
                var dtDetail = $('.table-price').DataTable({
                    searching: false,
                    paging: false,
                    info: false,
                    processing: true,
                    serverSide: true,
                    ajax: ({
                        url: '{{ route("order.dtDetailPayment") }}',
                        type: "POST",
                        data: {
                            'id': data.id
                        },
                        dataType: "JSON",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }),
                    columns: [{
                            data: 'DT_RowIndex',
                            render:function(data){
                                return '<p align="center">'+data+'</p>';
                            }
                        },
                        {
                    data: 'uang_masuk',
                    render: function(data){
                        return 'Rp.'+data;
                    }
                    },
                    {
                    data: 'total_pembayaran',
                    render: function(data){
                        return 'Rp.'+data;
                    }
                    },
                    {
                    data: 'sisa_pembayaran',
                    render: function(data){
                        if (data == 0.00){
                            return'-';
                        }else{
                            return data;
                        }
                    }
                    },

                    ],
                })





            });
        });
    })
</script>
@if(session('message'))
<script>
    toastr["success"]("{{ session('message') }}", "Success");
</script>
@endif
@stop

@section('script')

@stop
