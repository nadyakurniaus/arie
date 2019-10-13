@extends('back.layouts-gudang.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.min.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/buttons.dataTables.min.css') }}">


<link rel="stylesheet" href@extends('back.layouts.base') @section('style') <link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.css') }}">
<!-- {!! Html::script('js/angular.min.js', array('type' => 'text/javascript')) !!} -->
<!-- {!! Html::script('js/pembelian.js', array('type' => 'text/javascript')) !!} -->
@stop

@section('body')

<div class="page">
    <div class="page-header">
        <h1 class="page-title">Tambah Permintaan Pembelian Bahan Baku</h1>
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="javascript:void(0)">Bagian Gudang</a></li>
             <li class="breadcrumb-item"><a href="javascript:void(0)">Kelola Permintaan PBB</a></li>
             <li class="breadcrumb-item"><a href="javascript:void(0)">Permintaan PBB</a></li>
            <li class="breadcrumb-item active">Tambah </li>
        </ol>
        <div class="page-header-actions">
            <a href="{{ route('bahanbaku.index') }}" class="btn btn-md btn-icon btn-outline btn-warning btn-round" data-toggle="tooltip" data-original-title="Go back to role index">
                <i class="icon wb-arrow-left" aria-hidden="true"></i> &nbsp; Kembali
            </a>
        </div>
    </div>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-lg-12   col-xs-12">
                <!-- Panel Static Labels -->
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Form Tambah Permintaan Pembelian Bahan Baku</h3>
                    </div>
                    <div class="panel-body container-fluid">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="row" ng-controller="SearchItemCtrl">
                            <div class="col-md-12">
                                <div class="row">
                                    <!-- {!! Form::open(array('url' => 'order', 'class' => 'form-horizontal')) !!} -->
                                    {!! Form::open(['url' => 'pembelian', 'files' => true, 'role' => 'form', 'class' => 'form-loading-button']) !!}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="id_order" class="col-sm-5 control-label">Kode</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="id_order" id="id_order" value="{{$kode_pembelian}}" readonly />
                                            </div>
                                        </div>
                                        <br>
                                        <div id="hidden" hidden>
                                            <!-- <div class="form-group">
                                                <label for="id_order" class="col-sm-5 control-label">Metode :</label>
                                                <div class="col-sm-7">
                                                    <div class="radio-custom radio-primary">
                                                        <input type="radio" id="manual" name="inputRadios" checked="">
                                                        <label for="manual">Manual</label>
                                                    </div>
                                                    <div class="radio-custom radio-primary">
                                                        <input type="radio" id="otomatis" name="inputRadios">
                                                        <label for="otomatis">Otomatis</label>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <br>
                                            <div class="form-group">
                                                <label for="tanggal_selesai" class="col-sm-5 control-label">Tanggal Produksi</label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="icon wb-calendar" aria-hidden="true"></i>
                                                        </span>
                                                        <input type="text" class="form-control datepicker" data-plugin="datepicker" name="tanggal_produksi" id="tanggal_produksi" data-date-format='yyyy-mm-dd' readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_order" class="col-sm-4 control-label">Tanggal Permintaan</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="icon wb-calendar" aria-hidden="true"></i>
                                                    </span>
                                                    <input type="text" class="form-control datepicker" data-plugin="datepicker" name="tanggal_permintaan" id="tanggal_permintaan" data-date-format='yyyy-mm-dd' readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <br>

                                    </div>
                                </div>
                                <br>
                                <div class="table-responsive" id="tableManual">
                                    <table class="table table-bordered" id="items">
                                        <thead>
                                            <tr style="background-color: #f9f9f9;">
                                                <th width="5%" class="text-center">Aksi</th>
                                                <th width="30%" class="text-left">Nama Bahan Baku</th>
                                                <th width="20%" class="text-left">Jenis</th>
                                                <th width="10%" class="text-left">Ukuran</th>
                                                <th width="10%" class="text-left">Satuan</th>
                                                <th width="5%" class="text-center">Kuantitas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="item-row-0">
                                                <td class="text-center" style="vertical-align: middle;">
                                                    <button type="button" onclick="$(this).tooltip('destroy'); $('#item-row-0').remove(); totalItem();" data-toggle="tooltip" title="Hapus" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                                </td>
                                                <td>
                                                    <input value="" class="form-control typeahead" placeholder="Masukkan Nama Item " name="item[0][name]" type="text" id="item-name-0" autocomplete="off">
                                                    <input value="" name="item[0][item_id]" type="hidden" id="item-id-0">

                                                </td>
                                                <td class="text-right" style="vertical-align: middle;">
                                                    <span id="item-jenis-0">0</span>
                                                    <input value="" name="item[0][item_jenis]" type="hidden" id="item-id-jenis-0">
                                                </td>
                                                <td>
                                                    <select name="item[0][item_ukuran]" id="item_ukuran_0" class="form-control select2" onchange="$('#test').click()">
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="item[0][item_satuan]" id="item_satuan_0" class="form-control select2">
                                                    </select>
                                                </td>
                                                <td>
                                                    <input value="1" class="form-control text-center" name="item[0][quantity]" type="text" id="item-quantity-0">
                                                </td>
                                            </tr>
                                            <tr id="addItem">
                                                <td class="text-center"><button type="button" id="button-add-item" data-toggle="tooltip" title="Menambahkan" class="btn btn-xs btn-primary" data-original-title="Menambahkan"><i class="fa fa-plus"></i></button></td>
                                                <td class="text-right" colspan="5"></td>
                                            </tr>
                                            <tr id="tr-total">
                                                <td class="text-right" colspan="5"><strong>Total Barang</strong></td>
                                                <td class="text-right"><span id="grand-total">0</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-responsive" id="tableOtomatis" hidden>
                                    <table class="table table-hover table-otomatis table-striped w-full">
                                        <thead>
                                            <tr style="background-color: #f9f9f9;">
                                                <th width="30%" class="text-left">Id</th>
                                                <th width="30%" class="text-left">Nama Bahan</th>
                                                <th width="20%" class="text-left">Jenis</th>
                                                <th width="10%" class="text-left">Ukuran</th>
                                                <th width="5%" class="text-left">Satuan</th>
                                                <th width="5%" class="text-center">Kuantitas</th>
                                                <th width="5%" class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="comments" class="col-sm-2 control-label">Catatan</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control focus" name="comments" id="comments" placeholder="masukan keterangan..." required />
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-success btn-block">Simpan</button>
                                                <div hidden>
                                                    <button type="button" id="test" class="btn btn-success btn-block">Test</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <!-- End Panel Floating Labels -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('script')
<script src="{{ asset('global/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>
<script src="{{ asset('global/js/moment.js') }}"></script>
<script src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('global/js/Plugin/bootstrap-datepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script src="{{ asset('js/select2Pembelian.js') }}"></script>
<script src="{{ asset('global/vendor/select2/select2.min.js') }}"></script>
<script type="text/javascript">
    // var focus = false;
    var item_row = '1';
    var row_data = '0';
    var autocomplete_path = "{{ route('pembelian.autocomplete') }}";
    var metode = localStorage.metode;
    var getTanggal = localStorage.tanggal_produksi;

    $(document).ready(function() {

        if (metode == 'otomatis') {
            $('#tableOtomatis').removeAttr('hidden');
            $('#tableManual').attr('hidden', '');
            $('#hidden').removeAttr('hidden');
            $('#manual').prop("checked", true);
        } else {
            $('#tableManual').removeAttr('hidden');
            $('#tableOtomatis').attr('hidden', '');
            $('#hidden').attr('hidden', '');

        }
        // Discount popover
        $('a[rel=popover]').popover({
            html: true,
            placement: 'bottom',
            title: 'Diskon',
            content: function() {
                html = '<div class="discount box-body">';
                html += '    <div class="col-md-6">';
                html += '        <div class="input-group" id="input-discount">';
                html += '            <input id="pre-discount" class="form-control text-right" name="pre-discount" type="number">';
                html += '            <div class="input-group-addon"><i class="fa fa-percent"></i></div>';
                html += '        </div>';
                html += '    </div>';
                html += '    <div class="col-md-6">';
                html += '        <div class="discount-description">';
                html += '           of subtotal';
                html += '        </div>';
                html += '    </div>';
                html += '</div>';
                html += '<div class="discount box-footer">';
                html += '    <div class="col-md-12">';
                html += '        <div class="form-group no-margin">';
                html += '            <button type="button" id="save-discount" class="btn btn-success"><span class="fa fa-save"></span> &nbsp;Simpan</button>';
                html += '            <a href="javascript:void(0)" id="cancel-discount" class="btn btn-default"><span class="fa fa-times-circle"></span> &nbsp;Batal</a>';
                html += '       </div>';
                html += '    </div>';
                html += '</div>';

                return html;
            }
        });

    });

    $(document).on('click', '#button-add-item', function(e) {
        $.ajax({
            url: '{{ route("pembelian.add.item") }}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                item_row: item_row,
            },
            success: function(json) {
                if (json['success']) {
                    $('#items tbody #addItem').before(json['html']);
                    $('[data-toggle="tooltip"]').tooltip('hide');
                    saveDetail();
                    item_row++;
                    row_data++;
                }
            }
        });
    });

    $(document).on('keyup', '#items tbody .form-control', function() {
        totalItem();
    });
    var globalId;
    $(document).on('click', '.form-control.typeahead', function() {
        input_id = $(this).attr('id').split('-');

        item_id = parseInt(input_id[input_id.length - 1]);
        globalId = item_id;
        $(this).typeahead({
            minLength: 3,
            displayText: function(data) {
                return data.nama + ' (' + data.namaukuran + ')';
            },
            source: function(query, process) {
                $.ajax({
                    url: autocomplete_path,
                    type: 'GET',
                    dataType: 'JSON',
                    data: 'query=' + query,
                    success: function(data) {
                        return process(data);
                    }
                });
            },
            afterSelect: function(data) {
                $('#item-id-' + item_id).val(data.id);
                $('#item-quantity-' + item_id).val('1');
                $('#item-jenis-' + item_id).html(data.jenis);
                $('#item-jenis-' + item_id).html(data.jenis);
                $('#item-id-jenis-' + item_id).val(data.jenis);
                $('#item-total-' + item_id).html(data.total);
                $('#item_ukuran_' + item_id).select2(select2Ajax('Select', '{{ route("ppbb.select2") }}', 1));
                $('#item_satuan_' + item_id).select2();
                var das = $('#item-id-' + globalId).val()
                selectSatuan(das);
                totalItem();
            }
        });
    });




    function totalItem() {
        $.ajax({
            url: '{{ route("pembelian.total.item") }}',
            type: 'POST',
            dataType: 'JSON',
            data: $('#items input[type=\'text\'],#items input[type=\'number\'],#items input[type=\'hidden\'], #items textarea, #items select').serialize(),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(data) {
                if (data) {
                    $.each(data.items, function(key, value) {
                        $('#item-total-' + key).html(value);
                    });
                    $('#grand-total').html(data.grand_total);

                    $('.input-price').each(function() {
                        input_price_id = $(this).attr('id');
                        amount = $(this).maskMoney('unmasked')[0];

                        $(this).val(amount);

                        // $(this).trigger('focusout');
                    });
                }
            }
        });
    }
    $('#cekdata').click(() => {
        saveDetail();
    });
    var comments = 1;
    $('#comments').keypress(() => {
        if (comments == 1) {
            saveDetail();
            comments++;
        }
    });

    $("#manual, #otomatis").change(function() {
        if ($("#manual").is(":checked")) {
            $('#tableManual').removeAttr('hidden');
            $('#tableOtomatis').attr('hidden', '');
        } else if ($("#otomatis").is(":checked")) {
            $('#tableOtomatis').removeAttr('hidden');
            $('#tableManual').attr('hidden', '');

        }
    });

    function saveDetail() {
        $.ajax({
            url: '{{ route("pembelian.save.detail") }}',
            type: 'POST',
            dataType: 'JSON',
            data: {
                'id_bahanbaku': $('#item-id-' + row_data).val(),
                'jenis': $('#item-jenis-' + row_data).html(),
                'id_ukuran': $('#item_ukuran_' + row_data).val(),
                'satuan': $('#item_satuan_' + row_data).val(),
                'qty': $('#item-quantity-' + row_data).val(),
                'kode_pembelian': $('#id_order').val()
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(data) {
                console.log(data);
            }
        });
    }

    function selectSatuan(das) {
        var dataSatuan = {
            'id': das,
            'nama': $('#select2-item_ukuran_' + globalId + '-container').html().substring(47),
        };
        $.ajax({
            url: "{{ route('produkukuran.selectSatuan') }}",
            type: 'GET',
            data: dataSatuan,
            async: false,
            dataType: 'json',
            success: function(data) {
                var dataJson2 = data.data;
                var i;
                var html;
                for (i = 0; i < dataJson2.length; i++) {
                    html += '<option value="' + dataJson2[i].id + '">' + dataJson2[i].satuan + '</option>';
                }
                $('#item_satuan_' + item_id).html(html);
                $('#item_satuan_' + item_id).select2();
            }
        });
    }
    $('#test').click(() => {
        var das = $('#item-id-' + globalId).val()
        selectSatuan(das);

    });
</script>
<script type="text/javascript">
    $(function() {
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            todayBtn: "linked",
            language: "id"
        }).datepicker("setDate", new Date());
        setTimeout(() => {
            showTable();

        }, 100);
        $('#searchData').click(() => {})
        $('#tanggal_permintaan').val();
        $('#tanggal_produksi').val(moment(getTanggal).format('YYYY-MM-DD'));
        $('#tanggal_produksi').change(() => {
            showTable();
        });
    })

    function showTable() {
        if ($.fn.DataTable.isDataTable('.table-otomatis')) {
            $('.table-otomatis').DataTable().destroy();
        }
        $('.table-otomatis tbody').empty();
        var data = {
            'tanggal': moment($('#tanggal_produksi').val()).format('YYYY-MM-DD')
        };
        var dt = $(".table-otomatis").DataTable({

            ajax: ({
                url: '{{ route("pembelian.dtTemp") }}',
                type: "GET",
                data: data,
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }),
            ordering: false,
            columns: [{
                    data: 'id_temp'
                },
                {
                    data: 'nama_bahan'
                },
                {
                    data: 'jenis'
                },
                {
                    data: 'nama_ukuran'
                },
                {
                    data: 'satuan'
                },
                {
                    data: "stok",
                    render: function(data, type, row) {
                        return '<input type="number" class="form-control qty" value="' + data + '">';
                    }
                },
                {
                    data: "jumlah",
                    render: function(data, type, row) {
                        return 'tidak tersedia'
                    }
                },


            ],
        });
        $('.table-otomatis tbody').on('change', '.qty', function() {
            var data = dt.row($(this).parents('tr')).data();
            var inputVal = this.value;

            var cell = dt.cell($(this).parent('td'));

            var row = dt.row($(this).parents('tr'));

            var oldData = cell.data();

            cell.data(inputVal);
            var das = row.data();

            console.log(das.qty);



            var param = {
                'id': data.id_temp,
                'qty': das.qty,
            };
            $.ajax({
                url: "{{ route('pembelian.updateTemp') }}",
                type: 'POST',
                data: param,
                async: false,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {

                }
            });
            dt.draw();

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
