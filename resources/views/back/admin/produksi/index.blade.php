@extends('back.layouts.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.min.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.css') }}">

@stop

@section('body')
<!-- Page -->
<div class="page">
    <div class="page-header">
        <h1 class="page-title">Monitoring Produksi</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Admin</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Kelola Produksi</a></li>
            <li class="breadcrumb-item active">Lihat Monitoring Produksi</li>
        </ol>
        <div class="page-header-actions">
        </div>
    </div>
    <div class="page-content">
        <div class="panel">
            <header class="panel-heading">
                <header class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-15">
                                <div class="form-group">
                                    <label for="tanggal_order" class="col-sm-4 control-label">Tanggal Produksi</label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="icon wb-calendar" aria-hidden="true"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker" data-plugin="datepicker" name="tanggal_order" id="tanggal_order" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <button id="searchData" class="btn btn-outline btn-primary" type="button">
                                            <i class="icon wb-search" aria-hidden="true"></i> Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
            </header>
            <hr>
            <br>
            <div class="panel-body">

                <table class="table table-hover table-user table-striped w-full">
                    <thead>
                        <tr>
                            <th rowspan="2">#</th>
                            <th rowspan="2">ID Produksi</th>
                            <th rowspan="2">ID Order</th>
                            <!-- <th>Order</th> -->
                            <!-- <th>Selesai</th> -->
                            <th colspan="2" style="text-align: center;"> Tanggal</th>
                            <th rowspan="2">Pelanggan</th>
                            <th rowspan="2">Produk</th>
                            <th rowspan="2">Desc</th>
                            <th rowspan="2">Bahan Baku</th>
                            <th rowspan="2">Ukuran</th>
                            <th rowspan="2">Qty</th>
                            <th rowspan="2">Satuan</th>
                            <th rowspan="2">Proses</th>
                            <th rowspan="2">Status</th>
                        </tr>
                        <tr>
                            <th>Order</th>
                            <th>Selesai</th>
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
<script src="{{ asset('global/js/moment.js') }}"></script>
<script src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('global/js/Plugin/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            todayBtn: "linked",
            language: "id"
        }).datepicker("setDate", new Date());

        $('#searchData').click(() => {
            showTable();
        })

    })

    function showTable() {
        if ($.fn.DataTable.isDataTable('.table-user')) {
            $('.table-user').DataTable().destroy();
        }
        $('.table-user tbody').empty();
        var data = {
            'tanggal': $('#tanggal_order').val()
        };
        var table = $(".table-user").DataTable({

            ajax: ({
                url: '{{ route("produksi.dt") }}',
                type: "POST",
                data: data,
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }),
            searching: false,
            paging: false,
            info: false,
            ordering: false,
            columns: [{
                    data: 'DT_RowIndex'
                },
                {
                    data: 'kode_produksi'
                },
                {
                    data: 'no_faktur'
                },
                {
                    data: "tanggal_order",
                    render: function(data, type, row) {
                        return moment(data).format('MM-DD-YYYY');
                    }
                },
                {
                    data: "selesai_order",
                    render: function(data, type, row) {
                        return moment(data).format('MM-DD-YYYY');
                    }
                },
                {
                    data: 'name'
                },
                {
                    data: 'namaproduk'
                },
                {
                    data: 'desc'
                },
                {
                    data: 'bahanbaku'
                },
                {
                    data: 'ukuran'
                },
                {
                    data: 'jumlah'
                },
                {
                    data: 'satuan'
                },
                {
                    data: "proses",
                    render: function(data, type, row) {
                        if (data == 1) {
                            return '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' +
                                '<label for="Desain">Desain</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" autocomplete="off" disabled>' +
                                '<label for="Produksi">Produksi</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Printing" name="inputCheckboxRemember" autocomplete="off" disabled>' +
                                '<label for="Produksi">Printing</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" autocomplete="off" disabled>' +
                                '<label for="Cuting">Cuting</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' +
                                '<label for="Finishing">Finishing</label>' +
                                '</div>'
                        } else if (data == 2) {
                            return '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' +
                                '<label for="Desain">Desain</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' +
                                '<label for="Produksi">Produksi</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Printing" name="inputCheckboxRemember" autocomplete="off" disabled>' +
                                '<label for="Produksi">Printing</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" autocomplete="off" disabled>' +
                                '<label for="Cuting">Cuting</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' +
                                '<label for="Finishing">Finishing</label>' +
                                '</div>'
                        } else if (data == 0) {
                            return '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Desain" name="inputCheckboxRemember" autocomplete="off" disabled>' +
                                '<label for="Desain">Desain</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Produksi" name="inputCheckboxRemember"  autocomplete="off" disabled>' +
                                '<label for="Produksi">Produksi</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Printing" name="inputCheckboxRemember" autocomplete="off" disabled>' +
                                '<label for="Produksi">Printing</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" autocomplete="off" disabled>' +
                                '<label for="Cuting">Cuting</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' +
                                '<label for="Finishing">Finishing</label>' +
                                '</div>'
                        }
                        else if (data == 3) {
                            return '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' +
                                '<label for="Desain">Desain</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' +
                                '<label for="Produksi">Produksi</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Printing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' +
                                '<label for="Produksi">Printing</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" autocomplete="off" disabled>' +
                                '<label for="Cuting">Cuting</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' +
                                '<label for="Finishing">Finishing</label>' +
                                '</div>'
                        } else if (data == 4) {
                            return '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' +
                                '<label for="Desain">Desain</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' +
                                '<label for="Produksi">Produksi</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Printing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' +
                                '<label for="Produksi">Printing</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' +
                                '<label for="Cuting">Cuting</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' +
                                '<label for="Finishing">Finishing</label>' +
                                '</div>'
                        }else {
                            return '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' +
                                '<label for="Desain">Desain</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' +
                                '<label for="Produksi">Produksi</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Printing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' +
                                '<label for="Produksi">Printing</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' +
                                '<label for="Cuting">Cuting</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' +
                                '<label for="Finishing">Finishing</label>' +
                                '</div>'
                        }

                    }
                },
                {
                    data: 'status_prod'
                },

            ],
        });
    }
</script>
@if(session('message'))
<script>
    toastr["success"]("{{ session('message') }}", "Success");
</script>
@endif
@stop

@section('script')

@stop
