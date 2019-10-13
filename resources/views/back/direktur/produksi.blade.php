@extends('back.layouts-direktur.base')

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
        <h1 class="page-title">Produksi</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Direktur</a></li>
                  <li class="breadcrumb-item"><a href="javascript:void(0)">Lihat Pelaporan</a></li>
            <li class="breadcrumb-item active">Laporan Produksi</li>
        </ol>
        <div class="page-header-actions">
            <button id="printTest" class="btn btn btn-primary btn-outline" type="button">
                <i class="icon wb-print" aria-hidden="true"></i> Print
            </button>
        </div>
    </div>
    <div class="page-content">
        <div class="panel">
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
            <hr>
            <div class="printableArea">
            <div class="panel-body">
                    <div class="row print-only" id="headerFak">
                            <div class="col-lg-3 col-xs-12">
                                <h4>
                                 <img class="m-r-10" src="{{asset('global/assets/images/logo-blue.png')}}" alt="...">Percetakan Arie</h4>
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
                <header class="panel-heading">
                    <h4>Hasil Produksi</h4>
                </header>
                <table class="table table-hover table-user table-striped w-full">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">ID Produksi</th>
                            <th rowspan="2">ID Order</th>
                            <!-- <th>Order</th> -->
                            <!-- <th>Selesai</th> -->
                            <th colspan="2" class="dt-body-right"> Tanggal</th>
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
                <br>
                <header class="panel-heading">
                    <h4>Hasil Penggunaan Bahan Baku</h4>
                </header>
                <table class="table table-hover table-striped w-full" id="dt_hasil">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Bahan Baku</th>
                            <th>Ukuran</th>
                            <th>Qty yang Dibutuhkan</th>
                            <th>Jumlah Penggunaan</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>
                </table>
                <br></br>
                <div class="text-xs-right clearfix print-only row">
                        <div class="pull-xs-right">
                            <p>Tertanda:
                            <span>Supervisor Produksi</span>
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

@include('back.layouts.modal')
@stop
@section('script')
<script src="{{ asset('global/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>
<script src="{{ asset('global/js/moment.js') }}"></script>
<script src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('global/js/Plugin/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-bootstrap/buttons.print.min.js') }}"></script>
<script src="{{ asset('global/js/jquery.printarea.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $('#print').click(() => {
            $('.buttons-print').click();
        });
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            language: "id"
        }).datepicker("setDate", new Date());

        $('#searchData').click(() => {
            showTable();
            showTable2();
            $('#judul').html('Laporan Produksi dan Hasil Penggunaan Bahan Baku ' + $('#tanggal_order').val());
        })
        $("#printTest").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.printableArea").printArea(options);
        });

    })

    function showTable() {
        if ($.fn.DataTable.isDataTable('.table-user')) {
            $('.table-user').DataTable().destroy();
        }
        $('.table-user tbody').empty();
        var data = {
            'tanggal': moment($('#tanggal_order').val()).format('YYYY-MM-DD')
        };
        var table = $(".table-user").DataTable({

            ajax: ({
                url: '{{ route("direktur.dtProduksi") }}',
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
                                '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' +
                                '<label for="Finishing">Finishing</label>' +
                                '</div>'
                        }
                        else if (data == 0) {
                            return '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Desain" name="inputCheckboxRemember" autocomplete="off" disabled>' +
                                '<label for="Desain">Desain</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" autocomplete="off" disabled>' +
                                '<label for="Produksi">Produksi</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' +
                                '<label for="Finishing">Finishing</label>' +
                                '</div>'
                        } else {
                            return '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' +
                                '<label for="Desain">Desain</label>' +
                                '</div>' +
                                '<div class="checkbox-custom checkbox-default">' +
                                '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' +
                                '<label for="Produksi">Produksi</label>' +
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

    function showTable2() {
        if ($.fn.DataTable.isDataTable('#dt_hasil')) {
            $('#dt_hasil').DataTable().destroy();
        }
        $('.table-user tbody').empty();
        var data2 = {
            'tanggal': moment($('#tanggal_order').val()).format('YYYY-MM-DD')
        };
        var table2 = $("#dt_hasil").DataTable({

            ajax: ({
                url: '{{ route("direktur.dtProduksi") }}',
                type: "POST",
                data: data2,
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }),
            dom: 'Bfrtip',
            buttons: [{
                extend: 'print',
                title: 'Laporan Produksi',

            }],
            searching: false,
            paging: false,
            info: false,
            ordering: false,
            columns: [{
                    data: 'DT_RowIndex'
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
                    data: 'jumlah'
                },
                {
                    data: 'satuan'
                }

            ],
        });
        $('.buttons-print').attr('hidden', '');
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
