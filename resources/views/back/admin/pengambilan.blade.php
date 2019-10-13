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
            <h1 class="page-title">Pengambilan Barang (Produk Jadi)</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Admin</a></li>
                <li class="breadcrumb-item active">Kelola Pengambilan Barang (Produk Jadi)</li>
            </ol>
            <div class="page-header-actions">

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
                                <th>#</th>
                                <th>ID Order</th>
                                <th> Tanggal Order</th>
                                <th> Tanggal Selesai </th>
                                <th>Pelanggan</th>
                                <th>Produk</th>
                                <th>Desc</th>
                                <th>Bahan Baku</th>
                                <th>Ukuran</th>
                                <th>Qty</th>
                                <th>Status Produksi</th>
                                <th>Status Pembayaran</th>
                                <th>Penerima</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
<div class="modal fade modal-primary in" id="ModalPengambilan" aria-hidden="false" aria-labelledby="exampleFormModalLabel"
role="dialog" tabindex="-1">
  <div class="modal-dialog">
  <form class="modal-content" id="form-pengambilan" method="POST">
      @method('PUT')
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      <h4 class="modal-title" id="exampleFormModalLabel">Form Ubah Pengambilan (Produk Jadi)</h4>
      </div>
      <div class="modal-body">
            <div class="row">
                    <div class="col-md-6">
                <div class="form-group form-material" data-plugin="formMaterial">
                    <label class="label" for="inputText">No Faktur:</label>
                  <input type="text" class="form-control" name="no_faktur" readonly/>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group form-material" data-plugin="formMaterial">
                      <label class="label" for="inputText">Nama Pemesan:</label>
                      <input type="text" class="form-control" name="nama_pemesan" readonly/>
                    </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-material" data-plugin="formMaterial">
                            <label class="label" for="inputText">Tanggal Ambil:</label><br>
                            <div class="col-md-1">
                            <span class="input-group-addon" style="background-color:white; border:none;">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span></div>
                            <div class="col-md-11">
                            <input type="text" class="form-control datepicker" data-plugin="datepicker" data-date-format='yyyy-mm-dd' name="tanggal_ambil" id="tanggal_ambil" readonly></div>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-material" data-plugin="formMaterial">
                                <label class="label" for="inputText"><strong>Detail Barang:</strong></label>
                                <table class="table table-striped" data-tablesaw-mode="swipe"
                                data-tablesaw-minimap style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Desc</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>1</th>
                                            <td><label id="lblproduk">N/A</label></td>
                                            <td><label id="lbldesc">N/A</label></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-material" data-plugin="formMaterial">
                            <label class="label" for="inputText">Status Pengambilan Barang (Produk Jadi) :</label>
                            <select name="status_pengambilan" class="form-control" data-placeholder="Select a State">
                                <option value="Ambil"> Ambil</option>
                                <option value="Belum diambil" selected> Belum diambil</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-material" data-plugin="formMaterial">
                            <label class="label" for="inputText">Nama Pengambil</label>
                            <input type="text" class="form-control" name="nama_pengambil" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-material" data-plugin="formMaterial">
                            <label class="label" for="inputText">No.Telepon Pengambil</label>
                            <input type="text" class="form-control" name="no_telf_pengambil" />
                        </div>
                    </div>
                </div>


        <div class="row">
          <div class="col-xs-12 col-md-12 pull-xs-right">
            <button type="submit" class="btn btn-primary">Ubah</button>
          </div>
        </div>
        @csrf
      </div>
    </form>
  </div>
</div>
<!-- End Modal -->

    @include('back.layouts.modal')
    @stop
    @section('script')
    <script src="{{ asset('global/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('global/js/moment.js') }}"></script>
    <script src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('.table-user').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("pengambilan.dt") }}',
                columns: [
                    {
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'no_faktur'
                    },
                    {
                        data: 'tanggal_order',
                        render: function(data, type, row) {
                        return moment(data).format('MM-DD-YYYY');
                    }
                    },
                    {
                        data: 'tanggal_selesai',
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
                    data: 'proses',
                    render: function(data){
                        if (data > 6){
                            return 'Telah diambil';
                        }else{
                            return 'Done';
                        }
                    }
                },
                {
                    data: 'status',
                    render: function(data){
                        if (data == 1){
                            return 'Lunas';
                        }else if (data == 0){
                            return 'Belum Lunas';
                        }
                    }
                },
                {
                    data: 'status_penerimaan',
                },
                {
                    data: 'id_prod',
                    render: function(data){
                        return '<button class="btn btn-xs btn-icon btn-primary btn-round btn-pengambilan" role="menuitem" data-target="#ModalPengambilan" data-id="'+data+'" data-toggle="modal"><i class="icon wb-refresh" aria-hidden="true"></i></button>'+
                        '<a href="/pengambilan/faktur/'+data+' " class="btn btn-xs btn-icon btn-warning btn-round"><i class="icon wb-print" aria-hidden="true"></i></a>'
                        ;
                    }
                }
                ],
            })
            $('.table-user').on('draw.dt', function () {
                $('.btn-pengambilan').on('click', function (e) {
                    let id = $(this).data('id');
                    let url = '{{ route("pengambilan.edit", ':id') }}';
                    let urlw = '{{ route("pengambilan.update", ':id') }}';
                    urlw=urlw.replace(':id', id);
                    url=url.replace(':id', id);
                    $.ajax({
                        url:url,
                        method:"get",
                        dataType:"json",
                        success:function(res){
                            $('[name=no_faktur]').val(res.no_faktur);
                            $('[name=nama_pemesan]').val(res.nama_pemesan);
                            $('#lblproduk').html(res.namaproduk);
                            $('#lbldesc').html(res.desc);
                            $('#form-pengambilan').attr('action', urlw)
                        }
                    })

                });
            });
            $('.datepicker').datepicker();
            $("#tanggal_ambil").datepicker().datepicker("setDate", new Date());
        })

    </script>

    @if(session('message'))
    <script>
        toastr["info"]("{{ session('message') }}", "Success");

    </script>
    @endif
@stop

@section('script')

@stop
