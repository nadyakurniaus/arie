@extends('back.layouts-finance.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.min.css') }}">
@stop

@section('body')
<!-- Page -->
<div class="page">
    <div class="page-header">
        <h1 class="page-title">Data Pembayaran</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/finance">Finance</a></li>
            <li class="breadcrumb-item active">Pembayaran</li>
        </ol>
    </div>
    <div class="page-content">
        <div class="panel">
            <header class="panel-heading">
                <div class="panel-actions"></div>
                <h3 class="panel-title"></h3>
            </header>
            <div class="panel-body">
                <table class="table table-hover table-user table-striped w-full">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Faktur</th>
                            <th>Nama Pemesan</th>
                            <th>Tanggal Order</th>
                            <th>Tanggal Selesai</th>
                            <th>No Telepon</th>
                            <th>Status</th>
                            <th>Aksi</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                </table>
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
                <h4 class="modal-title"> Detail Order </h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-detail table-striped w-full">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Id Produk</th>
                            <th>Nama Produk</th>
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
<div class="modal fade modal-fade-in-scale-up" id="exampleNiftyFadeScale1" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"> Detail Pembayaran </h4>
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
<!-- modal end -->

@include('back.layouts.modal')
@stop
@section('script')
<script src="{{ asset('global/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>
<script src="{{ asset('global/js/moment.js') }}"></script>

<script type="text/javascript">
    $(function() {
        var dt = $('.table-user').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("pembayaran.dt2") }}',

            columns: [{
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
                    data: 'tanggal_order',
                    render: function(data, type, row) {
                        return moment(data).format('DD MMMM, YYYY');
                    }
                },
                {
                    data: 'tanggal_selesai',
                    render: function(data, type, row) {
                        return moment(data).format('DD MMMM, YYYY');
                    }
                },
                {
                    data: 'no_telfon'
                },
                {
                    data: 'status',
                    render: function(data){
                        if (data == 0){
                            return 'DP';
                        }else{
                            return 'Lunas';
                        }
                    }
                },

                {
                    data: 'action'
                },
                {
                    data: 'id',
                    render: function(data){
                    return '<button class="btn btn-xs btn-icon btn-warning btn-round" data-target="#exampleNiftyFadeScale" data-toggle="modal"><i class="icon wb-list" aria-hidden="true"></i></button>'+
                    '<button class="btn btn-xs btn-icon btn-success btn-round" data-target="#exampleNiftyFadeScale1" data-toggle="modal"><i class="icon fa-dollar" aria-hidden="true">$</i></button>'
                    ;
                    }
                }

            ],
        })
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
                        url: '{{ route("pembayaran.dtDetail") }}',
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
                            data: 'idProduk',
                        },
                        {
                            data: 'nama_produk',
                        },
                        {
                            data: 'harga',
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
                        url: '{{ route("pembayaran.dtDetailPayment") }}',
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

        // table detail


    })
</script>
@if(session('message'))
<script>
    toastr["info"]("{{ session('message') }}", "Success");
</script>
@endif
@stop

@section('script')

@stop
