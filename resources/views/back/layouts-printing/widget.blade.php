@extends('back.layouts-printing.base')

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
        <h1 class="page-title">Printing</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Bagian Offset</a></li>
            <li class="breadcrumb-item active">Tambah Printing</li>
        </ol>
        <div class="page-header-actions">
        </div>
    </div>
    <div class="page-content">
        <div class="panel">
            {{-- <header class="panel-heading">
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
            </header> --}}
            <div class="panel-body">
                <header class="panel-heading">
                    <h4 align="center" id="labelTanggal">
                    </h4>
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
<!-- modal start -->
<div class="modal fade modal-3d-sign" id="modalPrinting" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Proses Printing</h4>
                <br>
                <div class="form-group">
                    <label for="tanggal_order" class="col-sm-4 control-label">Tanggal Masuk Printing</label>
                    <div class="col-sm-6">
                        <input type="hidden" id="primaryP">
                        <input type="hidden" id="targetP">
                        <input type="hidden" id="id_produksiP">
                        <input type="text" name="qty_printing" id="qty_printing" class="form-control datepicker" data-plugin="datepicker"
                            readonly />
                    </div>
                </div><br><br>
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>ID Produksi</th>
                            <th id="thidproduksi2">-</th>
                        </tr>
                        <tr>
                            <th>No. Faktur Order</th>
                            <th id="thnofaktur2">-</th>
                        </tr>
                        <tr>
                            <th>Nama Pemesan</th>
                            <th id="thnama2">-</th>
                        </tr>
                        <tr>
                            <th>Nama Produk</th>
                            <th id="thnamaproduk2">-</th>
                        </tr>
                        <tr>
                            <th>Tanggal Masuk Produksi</th>
                            <th id="target_produksi2">-</th>
                        </tr>
                        <tr>
                            <th>Tanggal Masuk Printing</th>
                            <th id="cacat_cuting2">-</th>
                        </tr>
                        <tr>
                            <th>Tanggal Masuk Cutting</th>
                            <th id="cacat_printing2">-</th>
                        </tr>
                        <tr>
                            <th>Tanggal Masuk Finishing</th>
                            <th id="qty_finishing2">-</th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="simpanPrinting" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- modal end -->


<!-- modal start -->
<div class="modal fade modal-3d-sign" id="modalDetail" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Detail Produksi</h4>
                <br>
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>ID Produksi</th>
                            <th id="thidproduksi">-</th>
                        </tr>
                        <tr>
                            <th>No. Faktur</th>
                            <th id="thnofaktur">-</th>
                        </tr>
                        <tr>
                            <th>Nama Pemesan</th>
                            <th id="thnama">-</th>
                        </tr>
                        <tr>
                            <th>Nama Produk</th>
                            <th id="thnamaproduk">-</th>
                        </tr>
                        <tr>
                            <th>Tanggal Masuk Produksi</th>
                            <th id="target_produksi">-</th>
                        </tr>
                        <tr>
                            <th>Tanggal Masuk Printing</th>
                            <th id="cacat_cuting">-</th>
                        </tr>
                        <tr>
                            <th>Tanggal Masuk Cutting</th>
                            <th id="cacat_printing">-</th>
                        </tr>
                        <tr>
                            <th>Tanggal Masuk Finishing</th>
                            <th id="qty_finishing">-</th>
                        </tr>
                    </tbody>

                </table>
            </div>
            <div class="modal-body">


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
<script src="{{ asset('global/vendor/bootbox/bootbox.js') }}"></script>
<script src="{{ asset('global/vendor/bootstrap-sweetalert/sweetalert.js') }}"></script>
<script>
    $(function() {
        $("#qty_printing").datepicker({
            format: 'dd-mm-yyyy',
            todayBtn: "linked",
            language: "id"
        }).datepicker("setDate", new Date());
        var dateTemp;
        var dtTable;
        setTimeout(() => {
            var setTanggal = $('#tanggal_order').val();
            $('#labelTanggal').html('Daftar Menunggu Proses Printing ');
            showTable();

        }, 300);
        $('#tanggal_order , #tanggal_produksi2').datepicker({
            format: 'dd-mm-yyyy',
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
        $('#simpanPrinting').click(() => {
            $.ajax({
                url: '{{ route("printing.simpanDetail") }}',
                type: "POST",
                data: {
                    'id': $('#id_produksiP').val(),
                    'qty': $('#qty_printing').val(),
                    'type': 'printing',
                    'status': '3',
                    'primary': $('#primaryP').val()


                },
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#qty_printing').val('');
                    showTable();
                    alert('Berhasil!');
                }
            })
        })


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
            'tanggal': $('#tanggal_order').val()
        };
        dtTable = $(".table-user").DataTable({

            ajax: ({
                url: '{{ route("printing.dtProduksiPTG2") }}',
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
            columnDefs: [
                { width: 120, targets: 14 },
                { width: 110, targets: 13 },
                { width: 210, targets: 12 },
            ],
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
                        return moment(data).format('DD/MM/YYYY');
                    }
                },
                {
                    data: "tanggal_selesai",
                    render: function(data, type, row) {
                        return moment(data).format('DD/MM/YYYY');
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
                    data: 'jadwal_produksi',
                    render: function(data, type, row) {
                        return moment(data).format('DD/MM/YYYY');
                    }
                },
                {
                    data: 'proses',
                    render: function(data, type, row) {

                        if (data != '2') {
                            return '<button type="button" class="btn btn-icon btn-success btn-printing" data-target="#modalPrinting" data-toggle="modal" disabled><i class="icon wb-print" aria-hidden="true"></i></button>'+
                            '<button type="button" class="btn btn-icon btn-info" data-target="#modalDetail" data-toggle="modal"><i class="icon wb-info" aria-hidden="true"></i></button>'

                        }
                        else{
                            return '<button type="button" class="btn btn-icon btn-success btn-printing" data-target="#modalPrinting" data-toggle="modal"><i class="icon wb-print" aria-hidden="true"></i></button>'+
                            '<button type="button" class="btn btn-icon btn-info" data-target="#modalDetail" data-toggle="modal"><i class="icon wb-info" aria-hidden="true"></i></button>'
                        }
                    }
                }

            ]
        })



        $(".table-user tbody").on('click', 'tr button.btn.btn-cuting', function() {
            var datas = dtTable.row($(this).parents('tr')).data();
            $('#id_produksiC').val(datas.id_produksi);
            $('#primaryC').val(datas.ored_id);
            $('#targetC').val(datas.jumlah);

            $('#idProduksi').html(datas.kode_produksi);
            $('#nomor_faktur').html(datas.no_faktur);
            $('#Pemesan').html(datas.name);
            $('#Produk').html(datas.namaproduk);
            $('#targetPrint').html(datas.jumlah);
            $.ajax({
                url: '{{ route("printing.getInfo") }}',
                type: "GET",
                data: {
                    'id_produksi': datas.id_produksi
                },
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    console.log(data)
                    $('#cctc').html(data[0].qty);
                    $('#cctp').html(data[1].qty);

                    var total = parseInt($('#target_produksi').html()) - parseInt($('#cacat_cuting').html()) - parseInt($('#cacat_printing').html());
                     $('#qtyp').html(total)
                }
            })

        });

        $(".table-user tbody").on('click', 'tr button.btn.btn-printing', function() {
            var datas = dtTable.row($(this).parents('tr')).data();
            $('#id_produksiP').val(datas.id_produksi);
            $('#primaryP').val(datas.ored_id);
            $('#targetP').val(datas.jumlah);

            $('#thidproduksi2').html(datas.kode_produksi);
            $('#thnofaktur2').html(datas.no_faktur);
            $('#thnama2').html(datas.name);
            $('#thnamaproduk2').html(datas.namaproduk);
            $.ajax({
                url: '{{ route("printing.getInfo") }}',
                type: "GET",
                data: {
                    'id_produksi': datas.id_produksi
                },
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    console.log(data)
                    var cuk = moment(data[0].qty).format('DD/MM/YYYY');
                    $('#target_produksi2').html(cuk);
                    var jing = moment(data[1].qty).format('DD/MM/YYYY');
                    $('#cacat_cuting2').html(jing);
                    var dan = moment(data[2].qty).format('DD/MM/YYYY');
                    $('#cacat_printing2').html(dan);
                    var tot = moment(data[3].qty).format('DD/MM/YYYY');
                    $('#qty_finishing2').html(tot);

                }
            })
        });

        $(".table-user tbody").on('click', 'tr button.btn.btn-info', function() {
            var datas = dtTable.row($(this).parents('tr')).data();
            $('#id_produksiP').val(datas.id_produksi);
            $('#thidproduksi').html(datas.kode_produksi);
            $('#thnofaktur').html(datas.no_faktur);
            $('#thnama').html(datas.name);
            $('#thnamaproduk').html(datas.namaproduk);
             $.ajax({
                url: '{{ route("printing.getInfo") }}',
                type: "GET",
                data: {
                    'id_produksi': datas.id_produksi
                },
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    console.log(data)
                    var cuk = moment(data[0].qty).format('DD/MM/YYYY');
                    $('#target_produksi').html(cuk);
                    var dan = moment(data[1].qty).format('DD/MM/YYYY');
                    $('#cacat_cuting').html(dan);
                    var jing = moment(data[2].qty).format('DD/MM/YYYY');
                    $('#cacat_printing').html(jing);
                    var tot = moment(data[3].qty).format('DD/MM/YYYY');
                    $('#qty_finishing').html(tot)
                }
            })
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
