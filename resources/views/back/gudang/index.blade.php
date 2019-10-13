@extends('back.layouts-gudang.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.min.css') }}">
@stop

@section('body')

<div class="page">
    <div class="page-header">
        <h1 class="page-title">Bahan Baku</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">Bahan Baku</li>
        </ol>
        <div class="page-header-actions">
            <a class="btn btn-md btn-icon btn-primary btn-round" href="{{ route('bahanbaku.create') }}" data-toggle="tooltip"
                data-original-title="Add new Bahan Baku">
                <i class="icon wb-plus" aria-hidden="true"></i> &nbsp; Tambah Bahan Baku
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
                            <th>#</th>
                            <th>Bahan Baku</th>
                            <th>Jenis</th>
                            <th>Ukuran</th>
                            <th>Stok</th>
                            <th>Satuan</th>
                            <th>Action</th>
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
            ajax: '{{ route("bahanbaku.dt") }}',
            columns: [{
                    data: 'DT_RowIndex'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'jenis',
                    name: 'jenis'
                },
                {
                    data: 'ukuran',
                    name: 'ukuran'
                },
                {
                    data: 'stok',
                    name: 'stok'
                },
                {
                    data: 'satuan',
                    name: 'satuan'
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

                let url = '{{ route("bahanbaku.destroy", ':id') }}';
                url = url.replace(':id', id);

                $('.delete-type').html('bahanbaku');
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
    toastr["success"]("{{ session('message') }}", "Success");

</script>
@endif
@stop
