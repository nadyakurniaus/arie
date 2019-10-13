@extends('back.layouts.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.min.css') }}">
@stop

@section('body')

<div class="page">
    <div class="page-header">
        <h1 class="page-title">Monitoring Bahan Baku</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Admin</a></li>
            <li class="breadcrumb-item active">Lihat Monitoring Bahan Baku</li>
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
                            <th>ID Bahan Baku</th>
                            <th>Bahan Baku</th>
                            <th>Jenis</th>
                            <th>Ukuran</th>
                            <th>Stok</th>
                            <th>Satuan</th>
                            <th>Minimum</th>
                            <th>Keterangan</th>
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
            ajax: '{{ route("adminbahan.dt") }}',
            columns: [{
                    data: 'DT_RowIndex'
                },
                {
                    data: 'idBB',
                },
                {
                    data: 'bahanbaku',
                },
                {
                    data: 'jenis',
                },
                {
                    data: 'namaukuran',
                },
                {
                    data: 'stok',
                },
                {
                    data: 'satuan',
                },
                {
                    data: 'minimum',
                },
                {
                    data: 'keterangan'
                }
            ],
        })
    })

</script>
@if(session('message'))
<script>
    toastr["success"]("{{ session('message') }}", "Success");

</script>
@endif
@stop
