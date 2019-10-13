@extends('back.layouts-adminsys.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.min.css') }}">
@stop

@section('body')
<!-- Page -->
<div class="page">
        <div class="page-header">
            <h1 class="page-title">Pengguna </h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Admin System</a></li>
                <li class="breadcrumb-item active">Kelola Pengguna</li>
            </ol>
            <div class="page-header-actions">
                <a class="btn btn-md btn-icon btn-primary btn-round" href="{{ route('user.create') }}" data-toggle="tooltip"
                    data-original-title="Add new User">
                    <i class="icon wb-plus" aria-hidden="true"></i> &nbsp; Tambah Pengguna
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
                                <th>ID Pengguna</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>E-mail</th>
                                <th>Level</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
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
    <script type="text/javascript">
        $(function () {
            $('.table-user').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("users.dt") }}',
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'idUser'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role',
                        render: function(data){
                            if (data == 'adminsys'){
                                return ' '+data;
                            }else if ( data == 'setting'){
                                return 'Bagian Setting ';
                            }else if ( data == 'admin'){
                                return 'Admin ';
                            }else if ( data == 'supervisor'){
                                return 'Supervisor Produksi ';
                            }else if ( data == 'manajer'){
                                return 'Manajer ';
                             }else if ( data == 'direktur'){
                                return 'Direktur ';
                            }else if( data == 'finance'){
                                return 'Bagian Finance ';
                            }else if( data == 'gudang'){
                                return 'Bagian Gudang ';
                            }else if( data == 'printing'){
                                return 'Bagian Offset ';
                            }else if( data == 'cutting'){
                                return 'Bagian Cutting ';
                              }else if( data == 'finishing'){
                                return 'Bagian Finishing ';
                            }else{
                                return data;
                            }
                        }
                    },
                    {
                        data: 'status',
                        render: function(data){
                            if (data == '1'){
                                return '<td class="text-xs-center"><span class="tag tag-pill tag-success">Aktif</span></td>';
                            }else{
                                return '<td class="text-xs-center"><span class="tag tag-pill tag-dark">Tidak Aktif</span></td>';
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
            })

            $('.table-user').on('draw.dt', function () {

                $('.btn-delete').on('click', function (e) {
                    let id = $(this).data('id');
                    let name = $(this).data('name');

                    let url = '{{ route("user.destroy", ':id') }}';
                    url = url.replace(':id', id);

                    $('.delete-type').html('user');
                    $('.delete-hint').html(name);

                    $('.btn-confirm-delete').on('click', function (e) {
                        $('.hiddenDeleteForm').attr('action', url)
                        $('.hiddenDeleteForm').submit();
                    });

                });
            });

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
