@extends('back.layouts-direktur.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.bootstrap4.min.css">
@stop

@section('body')
<!-- Page -->
<div class="page">
    <div class="page-header">
        <h1 class="page-title">Price List Produk</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Direktur</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Lihat Pelaporan</a></li>
            <li class="breadcrumb-item active">Laporan Price List Produk</li>
        </ol>
        <div class="page-header-actions">

                <a href="{{route('laporan.pricelistDirektur')}}" class="btn btn btn-primary btn-outline" type="button">
                        <i class="icon wb-print" aria-hidden="true"></i> Print
                    </a>
        </div>
    </div>
    <div class="page-content">
        <div class="panel">
            <header class="panel-heading">
                <div class="panel-actions"></div>
                <h3 class="panel-title">Price List Jenis Cetak Offset</h3>
            </header>

            <div class="panel-body">
                <table class="table table-hover table-user table-striped w-full" >
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Produk</th>
                            <th>Nama</th>
                            <th>Bahan Baku</th>
                            <th>Ukuran</th>
                            <th>Kebutuhan</th>
                            <th>Sisi Cetak</th>
                            <th>Quantity</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>
    <div class="page-content">
        <div class="panel">
            <header class="panel-heading">
                <div class="panel-actions"></div>
                <h3 class="panel-title">Price List Jenis Cetak Digital Printing</h3>
            </header>
            <div class="panel-body">
                <table class="table table-hover table-user2 table-striped w-full">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID Produk</th>
                            <th>Nama</th>
                            <th>Bahan Baku</th>
                            <th>Ukuran</th>
                            <th>Kebutuhan</th>
                            <th>Sisi Cetak</th>
                            <th>Quantity</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@include('back.layouts.modal')
@stop
@section('script')
<script src="{{ asset('global/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-bootstrap/buttons.print.min.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $('#print').click(() => {
            $('.buttons-print').click();
        });
        var dt = $('.table-user').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'print',
                title: 'Daftar Harga Produk /Quantity Jenis Cetak Offset',

            }],
            ajax: '{{ route("direktur.dtPriceList") }}',
            columns: [{
                    data: 'DT_RowIndex'
                },
                {
                    data: 'idProduk',
                },
                {
                    data: 'nama',
                },
                {
                    data: 'bahan',
                },
                {
                    data: 'ukuran',
                },
                {
                    data: 'kebutuhan',
                },
                {
                    data: 'sisi_cetak',
                },
                {
                    data: 'quantity',
                },
                {
                    data: 'harga',
                }
            ],
        })
        var dt2 = $('.table-user2').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'print',
                title: 'Daftar Harga Produk /Quantity Jenis Cetak Digital Printing',

            }],
            ajax: '{{ route("direktur.dtPriceList2") }}',
            columns: [{
                    data: 'DT_RowIndex'
                },
                {
                    data: 'idProduk',
                },
                {
                    data: 'nama',
                },
                {
                    data: 'bahan',
                },
                {
                    data: 'ukuran',
                },
                {
                    data: 'kebutuhan',
                },
                {
                    data: 'sisi_cetak',
                },
                {
                    data: 'quantity',
                },
                {
                    data: 'harga',
                },
            ],
        })

    })
</script>
@stop

@section('script')

@stop
