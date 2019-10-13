@extends('back.layouts-gudang.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.min.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-sweetalert/sweetalert.css')}}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/buttons.dataTables.min.css') }}">

@stop

@section('body')
<!-- Page -->
<div class="page">
    <div class="page-header">
        <h1 class="page-title">Permintaan Pembelian Bahan Baku</h1>
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="javascript:void(0)">Bagian Gudang</a></li>
            <li class="breadcrumb-item active">Kelola Permintaan PBB</li>
        </ol>
        <div class="page-header-actions">
            <a class="btn btn-md btn-icon btn-primary btn-round" href="{{ route('pembelian.create') }}"
                onclick="myFunction()" data-toggle="tooltip" data-original-title="Add new User">
                <i class="icon wb-plus" aria-hidden="true"></i> &nbsp; Tambah Permintaan
            </a>
        </div>
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
                            <th>Kode PBB</th>
                            <th>Tanggal Permintaan</th>
                            <th>Status</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
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

<!-- modal start -->
<div class="modal fade modal-fade-in-scale-up" id="exampleNiftyFadeScale" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"> Detail Item</h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-detail table-striped w-full">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID PPPBB</th>
                            <th>Tanggal Permintaan</th>
                            <th>Bahan Baku</th>
                            <th>Ukuran</th>
                            <th>Jumlah Permintaan</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>
                </table>
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
<script src="{{ asset('global/vendor/bootstrap-sweetalert/sweetalert.js')}}"></script>
<script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-bootstrap/buttons.print.min.js') }}"></script>
<script src="{{ asset('global/js/moment.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $('#print').click(() => {
            $('.buttons-print').click();
        });
        myFunction();
        function myFunction() {
            localStorage.removeItem("metode");
            localStorage.removeItem("tanggal_produksi");
        }
        function tests() {
        alert('test');

        }

        var dt = $('.table-user').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("pembelian.dt") }}',
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
                            '<span>Bagian Gudang</span>'+
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
                    columns: [0,1,2,3,4, ':hidden']

                }
            }],
            columns: [{
                    data: 'DT_RowIndex'
                },
                {
                    data: 'kode',
                    name: 'kode'
                },
                {
                    data: 'tanggal_permintaan',
                    render:function(data){
                        return moment(data).format('DD-MM-YYYY');
                    }
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'catatan',
                    name: 'catatan'
                },
                {
                    data: "id",
                    render: function(data, type, row) {
                        return '<button type="button" class="btn btn-icon btn-detail btn-primary btn-outline" data-target="#exampleNiftyFadeScale" data-toggle="modal"><i class="icon wb-eye" aria-hidden="true"></i></button>' +
                            '<button type="button" class="btn btn-icon btn-warning btn-outline"><i class="icon wb-edit" aria-hidden="true"></i></button>' +
                            '<button type="button" class="btn btn-icon btn-delete btn-danger btn-outline"><i class="icon wb-trash" aria-hidden="true"></i></button>';
                    }
                },

            ],
        })
        $('.buttons-print').attr('hidden', '');
        $(".table-user tbody").on('click', 'tr button.btn.btn-detail', function() {
            var data = dt.row($(this).parents('tr')).data();
            if ($.fn.DataTable.isDataTable('.table-detail')) {
                $('.table-detail').DataTable().destroy();
            }
            $('.table-detail tbody').empty();
            var dtDetail = $('.table-detail').DataTable({
                searching: false,
                paging: false,
                info: false,
                scrollY: "200px",
                scrollX: "200px",
                processing: true,
                serverSide: true,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'print',
                    title: 'Rincian Permintaan Pembelian Bahan Baku'
                }],
                ajax: ({
                    url: '{{ route("pembelian.dtDetail") }}',
                    type: "POST",
                    data: {
                        'kode': data.kode
                    },
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }),
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'kode'
                    },
                    {
                        data: 'tanggal_permintaan'
                    },
                    {
                        data: 'nama_bahan'
                    },
                    {
                        data: 'nama_ukuran',
                    },
                    {
                        data: 'qty',
                    },
                    {
                        data: 'satuan',
                    }

                ],
            })

        });


        $(".table-user tbody").on('click', 'tr button.btn.btn-edit', function() {
            var data = dt.row($(this).parents('tr')).data();
            alert(data.kode)


        });
        $(".table-user tbody").on('click', 'tr button.btn.btn-delete', function() {
            var data = dt.row($(this).parents('tr')).data();
            swal({
                title: "Hapus Permintaan Pembelian Bahan Baku",
                text: "Apakah Anda yakin menghapus permintaanpembelian bahan baku ini ? Tekan tombol 'Ya' untuk melanjutkan",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                closeOnConfirm: false
                //closeOnCancel: false
            }, function() {
                var dataSatuan = {
                    'kode': data.kode,
                };
                $.ajax({
                    url: "{{ route('pembelian.delete') }}",
                    type: 'POST',
                    data: dataSatuan,
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

@section('script')
<script>
    $('#otomatisStok').click(() => {
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
        function tambahOtomatis() {
        localStorage.metode = 'otomatis';
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
</script>
@stop
