@extends('back.layouts-supervisor.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.min.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/buttons.dataTables.min.css') }}">
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
        <h1 class="page-title">Monitoring Produksi</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Supervisor Produksi</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Kelola Produksi</a></li>
            <li class="breadcrumb-item active">Monitoring Produksi</li>
        </ol>
        <div class="page-header-actions">
            <button id="print" class="btn btn btn-primary" type="button">
                    <i class="icon wb-print" aria-hidden="true"></i> Print
            </button>
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
            <div class="printableArea">
            <div class="panel-body">
                <div class="row print-only" id="headerFak">
                    <div class="col-lg-3 col-xs-12">
                        <h4>
                        <img class="m-r-10" src="global/assets/images/logo-blue.png" alt="...">Percetakan Arie</h4>
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
                <div class="row print-only">
                    <h4 align="center">Laporan Monitoring Produksi - {!! Carbon\Carbon::now()->format('d-m-Y') !!}</h4>
                </div>
                <table class="table table-hover table-user table-striped w-full">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
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
                            <th rowspan="2">Aksi</th>
                        </tr>
                        <tr>
                            <th>Order</th>
                            <th>Selesai</th>
                        </tr>
                    </thead>
                </table>
                <br>
                <div class="row">
                <div class="col-md-4 col-lg-4 col-xs-4 col-xl-4 offset-md-3" id="keterangan">
                    <div class="row">Status Produksi Selesai: </div>
                    <br>
                    <div class="row">Status Pending ( Setengah Jadi ): </div>
                    <br>
                    <div class="row">Status Tidak ada status: </div>
                </div>
                <div class="col-md-5 col-md-5 col-lg-5 col-xs-5 col-xl-5" id="keterangan_detail">
                    <div class="row"><label for="selesai" id="Done"></label></div>
                    <br>
                    <div class="row"><label for="selesai" id="Pending"></div>
                    <br>
                    <div class="row"><label for="selesai" id="noStats"></div>
                </div>
            </div>
                <div class="text-xs-right clearfix print-only row">
                    <div class="pull-xs-right">
                        <p>Tertanda:
                        <span>Bagian Supervisor</span>
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
<!-- modal start -->
<div class="modal fade modal-3d-sign" id="modal1" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Form Ubah Monitoring Produksi</h4>
                <br>
                <div class="form-group">
                    <label for="tanggal_order" class="col-sm-4 control-label">Status saat ini :</label>
                    <div class="col-sm-6">
                        <input type="hidden" id="id_produksi">
                        <select name="status" id="status" class="form-control">
                            <option value="tidak ada status">Tidak ada status</option>
                            <option value="pending">Pending</option>
                            <option value="done">Done</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-body">


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="updateStatus" class="btn btn-primary">Ubah</button>
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
<script src="{{ asset('global/js/moment.js') }}"></script>
<script src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('global/js/Plugin/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('global/js/jquery.printarea.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#keterangan').hide();
    $('#keterangan_detail').hide();
})
$("#print").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.printableArea").printArea(options);
        });
    $(function() {
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            todayBtn: "linked",
            language: "id"
        }).datepicker("setDate", new Date());

        $('#searchData').click(() => {
            showTable();
            $('#keterangan').show();
            $('#keterangan_detail').show();

        })
        $('#print').click(() => {
            $('.buttons-print').click();
        });
        $('.buttons-print').attr('hidden', '');
        $('#updateStatus').click(() => {
            $.ajax({
                url: '{{ route("produksi.updateStatus") }}',
                type: "POST",
                data: {
                    'id_produksi': $('#id_produksi').val(),
                    'status': $('#status').val()
                },
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    showTable();
                }
            })
        })
        $('#searchData').click(() => {
            var data = {
            'tanggal': $('#tanggal_order').val()
             };
            $.ajax({
                url: '{{ route("produksi.tidakAdaStatus") }}',
                type: "POST",
                data:data,
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#noStats').html(data);
                }
            })
            $.ajax({
                url: '{{ route("produksi.done") }}',
                type: "POST",
                data:data,
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#Done').html(data);
                }
            })
            $.ajax({
                url: '{{ route("produksi.pending") }}',
                type: "POST",
                data:data,
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#Pending').html(data);
                }
            })
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
                url: '{{ route("produksi.dtMonitoringSPV") }}',
                type: "POST",
                data: data,
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }),

            columnDefs: [
                { width: 120, targets: 14 },
                { width: 110, targets: 13 },
                { width: 210, targets: 12 },
            ],
            dom: 'Bfrtip',
            buttons: [{
                extend: 'print',
                title: 'Daftar Produksi Percetakan Arie',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            }],
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
                    data: 'proses_detail'
                },
                {
                    data: 'progress'
                },
                {
                    data: "id",
                    render: function(data, type, row) {
                        return '<button type="button" data-target="#modal1" data-toggle="modal" class="btn btn-icon btn-produksi btn-primary"><i class="icon wb-edit"></i></button>'
                    }
                }
            ],
        });
        $(".table-user tbody").on('click', 'tr button.btn.btn-produksi', function() {
            var datas = table.row($(this).parents('tr')).data();
            $('#status').val(datas.status);
            $('#id_produksi').val(datas.id_prod);

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
