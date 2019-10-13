@extends('back.layouts.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.min.css') }}">
@stop

@section('body')
<!-- Page -->
<div class="page">
        <div class="page-header">
            <h1 class="page-title">Produk</h1>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="/bagsetting">Admin</a></li>
            <li class="breadcrumb-item"><a href="/setting">Kelola Produk</a></li>
            <li class="breadcrumb-item active">Produk</li>
            </ol>
            <div class="page-header-actions">
                <a class="btn btn-md btn-icon btn-primary btn-round" href="{{ route('product.create') }}" data-toggle="tooltip"
                    data-original-title="Add new User">
                    <i class="icon wb-plus" aria-hidden="true"></i> &nbsp; Tambah Produk
                </a>
            </div>
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
                                <th>ID Produk</th>
                                <th>Nama</th>
                                <th>Nama Bahan</th>
                                <th>Ukuran Bahan</th>
                                <th>Kebutuhan</th>
                                <th>Jenis Cetak</th>
                                <th>Aksi</th>
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
    <script type="text/javascript">
        $(function () {
            $('.table-user').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("produk.dt") }}',
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'idProduk'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'bahan',
                        name: 'bahan'
                    },
                    {
                        data: 'ukuran',
                        name: 'ukuran'
                    },
                    {
                        data: 'kebutuhan',
                        name: 'kebutuhan'
                    },
                    {
                        data: 'jenis_cetak',
                        name: 'jenis_cetak'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                   
                ],
            })
    
            $('.table-user').on('draw.dt', function () {
    
                $('.btn-delete').on('click', function (e) {
                    let id = $(this).data('id');
                    let name = $(this).data('name');
    
                    let url = '{{ route("product.destroy", ':id') }}';
                    url = url.replace(':id', id);
    
                    $('.delete-type').html('user');
                    $('.delete-hint').html(name);
    
                    $('.btn-confirm-delete').on('click', function (e) {
                        $('.hiddenDeleteForm').attr('action', url)
                        $('.hiddenDeleteForm').submit();
                    });
    
                });
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