@extends('back.layouts-supervisor.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.min.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-sweetalert/sweetalert.css') }}">

@stop

@section('body')
<!-- Page -->
<div class="page">
    <div class="page-header">
        <h1 class="page-title">Produksi</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Supervisor Produksi</a></li>
            <li class="breadcrumb-item active">Produksi</li>
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
            <div class="panel-body">
                <header class="panel-heading">
                    <h4 id="labelTanggal">
                    </h4>
                </header>
                <table class="table table-hover table-user table-striped w-full">
                    <thead>
                        <tr>
                            <th rowspan="2">#</th>
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
                            <th rowspan="2">Jadwal Produksi</th>
                            <th rowspan="2">Aksi</th>
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

<div hidden>
    <button id="prosespending" class="btn btn btn-primary" data-target="#modal1" data-toggle="modal" type="button">
    </button>
</div>

@include('back.layouts.modal')
@stop
@section('script')
<script src="{{ asset('global/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-bootstrap/buttons.print.min.js') }}"></script>
<script src="{{ asset('global/js/moment.js') }}"></script>
<script src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('global/js/Plugin/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('global/js/Plugin/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('global/vendor/bootbox/bootbox.js') }}"></script>
<script src="{{ asset('global/vendor/bootstrap-sweetalert/sweetalert.js') }}"></script>
<script>
    $(function() {
        var dateTemp;
        var dtTable;
        setTimeout(() => {
            var setTanggal = moment($('#tanggal_order').val()).format('DD/MM/YY');
            $('#labelTanggal').html('Daftar Produksi ' + setTanggal);
            showTable();

        }, 300);
        $('#tanggal_order , #tanggal_produksi2').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            language: "id"
        }).datepicker("setDate", new Date());
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            language: "id"
        });

        $('#searchData').click(() => {
            showTable();
        });

        $('#print').click(() => {
            $('.buttons-print').click();
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
        dtTable = $(".table-user").DataTable({

            ajax: ({
                url: '{{ route("produksi.dtProduksiSPV2") }}',
                type: "POST",
                data: data,
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }),
            ordering: false,
            scrollX: true,
            scrollY: true,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'print',
                title: 'Daftar Produksi Percetakan Arie'
            }],
            columns: [{
                    data: 'DT_RowIndex'
                },
                {
                    data: 'kode_produksi'
                },
                {
                    data: 'faktur_detail'
                },
                {
                    data: "tanggal_order",
                    render: function(data, type, row) {
                        return moment(data).format('MM-DD-YYYY');
                    }
                },
                {
                    data: "tanggal_selesai",
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
                    data: 'nama_ukuran'
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
                    data: 'jadwal_produksi',
                    render: function(data, type, row) {
                        return moment(data).format('MM-DD-YYYY');
                    }
                },
                {
                    data: "proses",
                    render: function(data, type, row) {
                        if (data == 4) {
                            return '<button type="button" class="btn btn-icon btn-finishing btn-primary">Finishing</button>'
                        }else{
                            return'';
                        }
                    }
                }

            ]
        })

        $(".table-user tbody").off().on('click', 'tr button.btn.btn-produksi', function() {
            var datas = dtTable.row($(this).parents('tr')).data();
            var jadwalbaru;
            if (datas.status == 'pending') {
                bootbox.dialog({
                    title: "Ubah Jadwal Produksi",
                    message: '<form class="form-horizontal">' + '<div class="form-group row">' + '<label class="col-md-4 form-control-label" for="tanggal">Jadwal Produksi</label>' + '<div class="col-md-6">' + '<input type="date" class="form-control input-md" id="tanggal" name="tanggal" required> ' + '<span class="text-help">Jadwal baru untuk produksi</span></div>' + '</div>' + '</form>',
                    buttons: {
                        success: {
                            label: "Save",
                            className: "btn-success",
                            callback: function callback() {
                                var tanggal = $('#tanggal').val();
                                if (tanggal == '') {
                                    toastr.error("Tanggal produksi harus di isi !");
                                    return;
                                } else {
                                    $.ajax({
                                        url: '{{ route("produksi.prosesProduksi") }}',
                                        type: "POST",
                                        data: {
                                            'id_produksi': datas.id_produksi,
                                            'jadwal_produksi': tanggal
                                        },
                                        dataType: "JSON",
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        success: function(data) {
                                            toastr.info("Jadwal Berhasil di ubah ke <b>" + tanggal + "</b>");
                                            showTable();
                                        }
                                    })
                                }
                            }
                        }
                    }
                });
            } else {
                $.ajax({
                    url: '{{ route("produksi.prosesProduksi") }}',
                    type: "POST",
                    data: {
                        'id_produksi': datas.id_produksi,
                        'id_ukuran': datas.id_ukuran,
                        'jumlah': datas.jumlah,
                        'stok': datas.stok,
                        'jadwal_produksi': ''
                    },
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        showTable();
                    }
                })
            }

        });
        $(".table-user tbody").off().on('click', 'tr button.btn.btn-finishing', function() {
            var datas = dtTable.row($(this).parents('tr')).data();
            var jadwalbaru;
            if (datas.status == 'pending') {
                bootbox.dialog({
                    title: "Ubah Jadwal Produksi",
                    message: '<form class="form-horizontal">' + '<div class="form-group row">' + '<label class="col-md-4 form-control-label" for="tanggal">Jadwal Produksi</label>' + '<div class="col-md-6">' + '<input type="date" class="form-control input-md" id="tanggal" name="tanggal" required> ' + '<span class="text-help">Jadwal baru untuk produksi</span></div>' + '</div>' + '</form>',
                    buttons: {
                        success: {
                            label: "Save",
                            className: "btn-success",
                            callback: function callback() {
                                var tanggal = $('#tanggal').val();
                                if (tanggal == '') {
                                    toastr.error("Tanggal produksi harus di isi !");
                                    return;
                                } else {
                                    $.ajax({
                                        url: '{{ route("produksi.prosesFinishing") }}',
                                        type: "POST",
                                        data: {
                                            'id_produksi': datas.id_produksi,
                                            'jadwal_produksi': tanggal
                                        },
                                        dataType: "JSON",
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        success: function(data) {
                                            toastr.info("Jadwal Berhasil di ubah ke <b>" + tanggal + "</b>");
                                            showTable();
                                        }
                                    })
                                }
                            }
                        }
                    }
                });
            } else {
                $.ajax({
                    url: '{{ route("produksi.prosesFinishing") }}',
                    type: "POST",
                    data: {
                        'id_produksi': datas.id_produksi,
                        'id_ukuran': datas.id_ukuran,
                        'jumlah': datas.jumlah,
                        'stok': datas.stok,
                        'jadwal_produksi': ''
                    },
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        showTable();
                    }
                })
            }

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
