@extends('back.layouts-direktur.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.min.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-sweetalert/sweetalert.css') }}">
@stop

@section('body')

<div class="page">
    <div class="page-header">
    <h1 class="page-title">Permintaan Pembelian Bahan Baku</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/direktur">Direktur</a></li>
                  <li class="breadcrumb-item"><a href="/direktur">Lihat Pelaporan</a></li>
            <li class="breadcrumb-item active">Laporan Permintaan Pembelian BB</li>
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
                            <th>ID PPBB</th>
                            <th>Tanggal Permintaan</th>
                            <th>Bahan Baku</th>
                            <th>Ukuran</th>
                            <th>Jumlah Permintaan</th>
                            <th>Satuan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
                <br>
                <br>
                <div class="row">
                    <div class="col-md-10"> &nbsp;</div>
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

@include('back.layouts.update-modal')
@stop
@section('script')
<script src="{{ asset('global/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-bootstrap/buttons.print.min.js') }}"></script>
<script src="{{ asset('global/vendor/bootstrap-sweetalert/sweetalert.js')}}"></script>

<script type="text/javascript">
    $(function() {
        $('#print').click(() => {
            $('.buttons-print').click();
        });
        var dt = $('.table-user').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("direktur.dtPPBB") }}',
            dom: 'Bfrtip',
            buttons: [{
                extend: 'print',
                title: '',
                customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .prepend(
                            '<div class="row">'+
                            '<div class="col-lg-3 col-xs-12">'+
                            '<h4>'+
                            '<img class="m-r-10" src="{{asset('global/assets/images/logo-blue.png')}}" alt="...">Percetakan Arie</h4>'+
                            '<address>'+
                            'Jl. A.R. Hakim 107 Karawang Barat'+
                            '<br>'+
                            '<abbr title="Mail">E-mail:</abbr>&nbsp;&nbsp;percetakanarie@gmail.com'+
                            '<br>'+
                            '<abbr title="Phone">No. Telepon:</abbr>&nbsp;&nbsp;0267 402582'+
                            '<br>'+
                            '</address>'+
                            '</div>'+
                            '<div class="col-xs-12 col-lg-3 text-xs-left">'+
                            '<h4 align="center">Laporan Permintaan Pembelian Bahan Baku - {!!\Carbon\Carbon::now()->format('d/m/Y')!!} </h4>'+
                            '</div>'+
                            '</div>'+
                            '<div class="text-xs-right clearfix">'+
                            '<div class="pull-xs-right" style ="position: absolute;bottom: 0px;float:right;">'+
                            '<p>Tertanda:'+
                            '<span>Direktur</span>'+
                            '</p>'+
                            '<p class="page-invoice-amount">(_______________)'+
                            '</p>'+
                            '</div>'+
                            '</div>'
                        );

                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                },
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7, ':hidden']

                }
            }],
            columns: [{
                    data: 'DT_RowIndex'
                },

                {
                    data: 'kode',
                },
                {
                    data: 'tanggal_permintaan',
                },

                {
                    data: 'bahan',
                },
                {
                    data: 'ukuran',
                },
                {
                    data: 'qty',
                },
                {
                    data: 'satuan',
                },
                {
                    data: 'status',
                },

            ],
        })
        $('.buttons-print').attr('hidden', '');
        $(".table-user tbody").on('click', 'tr button.btn.btn-approve', function() {
            var datas = dt.row($(this).parents('tr')).data();
            swal({
                title: "Persetujuan Permintaan Pembelian Bahan Baku",
                text: "APakah Anda yakin inggin menyetujui Permintaan Pembelian Bahan Baku ini ?",
                type: "success",
                showCancelButton: true,
                confirmButtonClass: "btn-success",
                confirmButtonText: 'OK',
                closeOnConfirm: false
                //closeOnCancel: false
            }, function() {

                var param = {
                    'id': datas.id_pembelian,
                    'status': 'approved',
                };
                $.ajax({
                    url: "{{ route('manajer.approve') }}",
                    type: 'POST',
                    data: param,
                    async: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        swal(data.title, data.message, data.type);
                        dt.ajax.reload();
                    }
                });
            });
        });
        $(".table-user tbody").on('click', 'tr button.btn.btn-reject', function() {
            var datas = dt.row($(this).parents('tr')).data();
            swal({
                title: "Persetujuan Permintaan Pembelian Bahan Baku",
                text: "Apakah Anda yakin inggin menolak Permintaan Pembelian Bahan Baku ini ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-warning",
                confirmButtonText: 'OK',
                closeOnConfirm: false
                //closeOnCancel: false
            }, function() {

                var param = {
                    'id': datas.id_pembelian,
                    'status': 'rejected',
                };
                $.ajax({
                    url: "{{ route('manajer.approve') }}",
                    type: 'POST',
                    data: param,
                    async: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        swal(data.title, data.message, data.type);
                        dt.ajax.reload();
                    }
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
