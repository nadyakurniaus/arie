@extends('back.layouts-supervisor.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.min.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/buttons.dataTables.min.css') }}">

@stop

@section('body')
<!-- Page -->
<div class="page">
    <div class="page-header">
        <h1 class="page-title">Jadwal Produksi</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Supervisor Produksi</a></li>
            <li class="breadcrumb-item active">Kelola Jadwal Produksi</li>
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
                                <label for="tanggal_order" class="col-sm-4 control-label">Tanggal Selesai</label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="icon wb-calendar" aria-hidden="true"></i>
                                        </span>
                                        <input type="text" class="form-control datepicker" data-plugin="datepicker"
                                            name="tanggal_order" id="tanggal_order" readonly>
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
                            <th rowspan="2">Jadwal Produksi</th>
                            <th rowspan="2">Aksi</th>
                        </tr>
                        <tr>
                            <th>Order</th>
                            <th>Selesai</th>
                        </tr>
                    </thead>
                </table>
                <div class="row">
                    <div class="col-md-10">
                        <button id="cekKebutuhan" class="btn btn btn-primary" data-target="#modal1" data-toggle="modal"
                            type="button">
                            <i class="icon wb-search" aria-hidden="true"></i> Cek Kebutuhan Bahan Baku
                        </button>
                    </div>
                    <div class="col-md-2">
                        <button id="print" class="btn btn btn-primary" type="button">
                            <i class="icon wb-print" aria-hidden="true"></i> Print
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal start -->
<div class="modal fade modal-3d-sign" id="modal1" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Kebutuhan Bahan Baku untuk Daftar Produksi</h4>
                <br>
                <div class="form-group">
                    <label for="tanggal_order" class="col-sm-4 control-label">Tanggal Produksi</label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                            <input type="text" class="form-control datepicker" data-plugin="datepicker"
                                name="tanggal_produksi2" id="tanggal_produksi2" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button id="searchKebutuhan" class="btn btn-outline btn-primary" type="button">
                            <i class="icon wb-search" aria-hidden="true"></i> Search
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-body">

                <table class="table table-hover table-bahanbaku table-striped w-full">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bahan Baku</th>
                            <th>Ukuran</th>
                            <th>Qty yg dibutuhkan</th>
                            <th>Satuan</th>
                            <th>Status</th>
                    </thead>
                </table>
            </div>

        </div>
    </div>
</div>
<!-- modal end -->
<!-- modal start -->
<div class="modal fade modal-3d-sign" id="modalJadwal" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Ubah jadwal produksi</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_produksi">
                <label for="tanggal_order" class="col-sm-4 control-label">Tanggal Produksi</label>
                <div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="icon wb-calendar" aria-hidden="true"></i>
                        </span>
                        <input type="text" class="form-control datepicker" name="tanggal_produksi" id="tanggal_produksi"
                            readonly>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" id="ubahJadwal">Ubah</button>

            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                <!-- <button type="button" class="btn btn-primary">Ubah</button> -->
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
<script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-bootstrap/buttons.print.min.js') }}"></script>
<script src="{{ asset('global/js/moment.js') }}"></script>
<script src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('global/js/Plugin/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('global/js/Plugin/bootstrap-datepicker.js') }}"></script>
<script>
    $(function() {
        var dateTemp;
        var dtTable;
        setTimeout(() => {
            var setTanggal = moment($('#tanggal_order').val()).format('DD/MM/YY');
            $('#labelTanggal').html('Daftar tanggal selesai (Deadline) Produksi ' + setTanggal);
            showTable();

        }, 300);
        $('#tanggal_order , #tanggal_produksi2').datepicker({
            format: 'dd-mm-yyyy',
            todayBtn: "linked",
            language: "id"
        }).datepicker("setDate", new Date());

        var todayDate = new Date().getDate();
        var currDate = new Date();
        $('#tanggal_produksi').datepicker({
           format: 'dd-mm-yyyy',
            todayBtn: "linked",
            autoclose: true,
            startDate : currDate,
        });

        $('#searchData').click(() => {
            showTable();
        });
        $('#searchKebutuhan').click(() => {
            showTable2();
        });
        $('#print').click(() => {
            $('.buttons-print').click();
        });
        $('#cekKebutuhan').click(() => {
            showTable2();
        });
        $('#ubahJadwal').click(() => {
            prosesUbahJadwal();
        });
        // $('#tambahOtomatis').click(() => {
        //     tambahOtomatis();
        // });
        $('#permintaanOtomatis').click(() => {
            tambahOtomatis();
            localStorage.metode = 'otomatis';
            localStorage.tanggal_produksi = moment($("#tanggal_produksi2").val()).format('YYYY-MM-DD');
            $.ajax({
                url: '{{ route("produksi.create.session") }}',
                type: "POST",
                data: {
                    'tanggal_produksi': moment($("#tanggal_produksi2").val()).format('YYYY-MM-DD'),
                    'metode': 'otomatis'
                },
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    window.location.href = '{{ route("pembelian.create.with") }}';

                }
            })

        });


    })

    function prosesUbahJadwal() {
        $.ajax({
            url: '{{ route("produksi.ubahJadwal") }}',
            type: "POST",
            data: {
                'id_produksi': $('#id_produksi').val(),
                'tanggal_produksi': $("#tanggal_produksi").val()
            },
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(data) {
                alert(data);
                showTable();
            }
        })
    }

    function tambahOtomatis() {
        $.ajax({
            url: '{{ route("produksi.isiOtomatis") }}',
            type: "POST",
            data: {
                'tanggal': $("#tanggal_produksi2").val()
            },
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(data) {
                alert(data);
                showTable();
            }
        })
    }

    function showTable() {
        if ($.fn.DataTable.isDataTable('.table-user')) {
            $('.table-user').DataTable().destroy();
        }
        $('.table-user tbody').empty();
        var data = {
            'tanggal': $('#tanggal_order').val()
        };
        dtTable = $(".table-user").DataTable({

            ajax: ({
                url: '{{ route("produksi.dtJadwal2") }}',
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
                title: 'Daftar Jadwal Produksi Percetakan Arie',
                customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .prepend(
                            '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; margin-top:450px; margin-left:200px;height: 50%;" />'
                        );

                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                }
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
                        return moment(data).format('DD-MM-YYYY');
                    }
                },
                {
                    data: "tanggal_selesai",
                    render: function(data, type, row) {
                        return moment(data).format('DD-MM-YYYY');
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
                    data: 'proses_detail'
                },
                {
                    data: 'progress'
                },
                {
                    data: 'jadwal_produksi',
                    render: function(data){
                        return moment(data).format('DD-MM-YYYY');
                    }
                },
                {
                    data: "ored_id",
                    render: function(data, type, row) {
                        return '<button type="button" class="btn btn-icon btn-detail btn-primary btn-outline" data-target="#modalJadwal" data-toggle="modal"><i class="icon wb-eye" aria-hidden="true"></i></button>'
                    }
                }

            ]
        })

        $(".table-user tbody").on('click', 'tr button.btn.btn-detail', function() {
            var datas = dtTable.row($(this).parents('tr')).data();
            $('#tanggal_produksi').val(moment(datas.jadwal_produksi).format('YYYY-MM-DD'));
            $('#id_produksi').val(datas.id_produksi);
        });

        $('.buttons-print').attr('hidden', '');


    }


    function showTable2() {
        if ($.fn.DataTable.isDataTable('.table-bahanbaku')) {
            $('.table-bahanbaku').DataTable().destroy();
        }
        $('.table-bahanbaku tbody').empty();
        var data = {
            'tanggal': $('#tanggal_produksi2').val()
        };
        var table2 = $(".table-bahanbaku").DataTable({

            ajax: ({
                url: '{{ route("produksi.dtBahan") }}',
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
            columns: [{
                    data: 'DT_RowIndex'
                },
                {
                    data: 'nama'
                },
                {
                    data: 'nama_ukuran'
                },
                {
                    data: 'qty'
                },
                {
                    data: 'satuan'
                },
                {
                    data: "jembut",
                    render: function(data, type, row) {
                        if (data == 0) {
                            return '<span class="badge badge-danger">Tidak tersedia</span>'
                        } else {
                            return '<span class="badge badge-success">Tersedia</span>'
                        }
                    }
                },

            ]
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
