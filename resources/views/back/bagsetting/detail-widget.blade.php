@extends('back.layouts-setting.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.min.css') }}">
@stop

@section('body')

<div class="page">
    <div class="page-header">
        <h1 class="page-title">Desain Order</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/bagsetting">Setting</a></li>
            <li class="breadcrumb-item active">Design Order</li>
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
                            <th>ID Produksi</th>
                            <th>Tanggal Order</th>
                            <th>Tanggal Selesai</th>
                            <th>Nama Pemesan</th>
                            <th>Produk</th>
                            <th>Quantity</th>
                            <th>Desc</th>
                            <th>Design</th>
                            <th>Status Penerimaan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@stop
@section('script')
<script src="{{ asset('global/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('global/js/moment.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>
<script type="text/javascript">
 $(function () {
        $('.table-user').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("setting.dtDashboard") }}',
            columns: [{
                    data: 'DT_RowIndex'
                },

                {
                    data: 'kode_produksi',
                },
                {
                    data: 'tanggal_order',
                    render: function(data) {
                        return moment(data).format('MM-DD-YYYY');
                    }
                },

                {
                    data: 'tanggal_selesai',
                    render: function(data) {
                        return moment(data).format('MM-DD-YYYY');
                    }
                },
                {
                    data: 'nama_pemesan',
                },
                {
                    data: 'nama',
                },
                {
                    data: 'jumlah'
                },
                {
                    data: 'desc',
                },
                {
                    data: 'design',
                    render: function(data, type, row) {
                        if ( row.design === null) {
                            return '';
                        }else{
                            return  '<img src="{{ asset("storage/design/") }}/'+data+'" width="100">';
                        }
                    }
                },
                {
                    data: 'status',
                },
                {
                    data: 'action',
                },
            ],
        })

 })

</script>
@if(session('message'))
<script>
    toastr["info"]("{{ session('message') }}", "Success");

</script>
@endif
@stop
