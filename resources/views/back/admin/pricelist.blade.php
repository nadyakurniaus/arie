@extends('back.layouts.base')

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
            <li class="breadcrumb-item"><a href="/bagsetting">Admin</a></li>
            <li class="breadcrumb-item"><a href="/setting">Kelola Produk</a></li>
            <li class="breadcrumb-item active">Price List Produk</li>
        <div class="page-header-actions">
            
        <a href="{{route('laporan.pricelist')}}" class="btn btn btn-primary btn-outline" type="button">
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
                            <th>Nama Produk</th>
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
    <!-- modal start -->
    <div class="modal fade modal-fade-in-scale-up" id="exampleNiftyFadeScale" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-simple">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title"> Detail Harga</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-detail table-striped w-full">
                        <thead>
                            <tr>
                                <th>Quantity</th>
                                <th>Harga</th>
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
                            <th>No</th>
                            <th>ID Produk</th>
                            <th>Nama Produk</th>
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
            ajax: '{{ route("pricelist.dt") }}',
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
            ajax: '{{ route("pricelist2.dt") }}',
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
        
        $(".table-user tbody").on('click', 'tr button.btn.btn-primary', function() {
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
                    url: '{{ route("pricelist.dtDetail") }}',
                    type: "POST",
                    data: {
                        'id': data.id
                    },
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }),
                columns: [
                    
                    {
                        data: 'quantity'
                    },
                    {
                        data: 'harga',
                        render: function(data){
                            return 'Rp. '+data;
                        }
                    }

                ],
            })
        });
        $(".table-user2 tbody").on('click', 'tr button.btn.btn-primary', function() {
            var data = dt2.row($(this).parents('tr')).data();
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
                    url: '{{ route("pricelist2.dtDetail") }}',
                    type: "POST",
                    data: {
                        'id': data.id
                    },
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }),
                columns: [
                    
                    {
                        data: 'quantity'
                    },
                    {
                        data: 'harga',
                        render: function(data){
                            return 'Rp. '+data;
                        }
                    }

                ],
            })
        });
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