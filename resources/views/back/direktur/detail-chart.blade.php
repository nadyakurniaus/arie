@extends('back.layouts-direktur.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.min.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.css') }}">

@stop

@section('body')
<!-- Page -->
<div class="page">
    <div class="page-header">
        <h1 class="page-title">Detail Produksi</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Supervisor</a></li>
            <li class="breadcrumb-item active">Detail Produksi</li>
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
                                    <label id ="labelHeader" for="labelHeader" class="col-sm-4 control-label"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
            </header>
            <div class="panel-body">

                <table class="table table-hover table-user table-striped w-full">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">ID Produksi</th>
                            <th rowspan="2">ID Order</th>
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
                             <option value="">- Pilih Salah Satu -</option>
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
<script type="text/javascript">
    $(function() {
        $('#labelHeader').html('Produksi Bulan ' + localStorage.getItem('bulan') );
        showTable();
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            language: "id"
        }).datepicker("setDate", new Date());

      


    })

    function showTable() {
        if ($.fn.DataTable.isDataTable('.table-user')) {
            $('.table-user').DataTable().destroy();
        }
        $('.table-user tbody').empty();
        var data = {
            'month': localStorage.getItem('bulan')
        };
        var table = $(".table-user").DataTable({

            ajax: ({
                url: '{{ route("produksi.dtDetails") }}',
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
                        } else if (data == 0) {
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
                        } else if (data == 0) {
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
                    data: 'progress'
                }
            ],
        });
        $(".table-user tbody").on('click', 'tr button.btn.btn-produksi', function() {
            var datas = table.row($(this).parents('tr')).data();
            $('#status').val(datas.status);
            $('#id_produksi').val(datas.id_prod);
            // $.ajax({
            //     url: '{{ route("produksi.prosesProduksi") }}',
            //     type: "POST",
            //     data: {
            //         'id_produksi': datas.id_produksi
            //     },
            //     dataType: "JSON",
            //     headers: {
            //         'X-CSRF-TOKEN': '{{ csrf_token() }}'
            //     },
            //     success: function(data) {
            //         showTable();
            //     }
            // })
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