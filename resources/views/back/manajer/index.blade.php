@extends('back.layouts-manajer.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.min.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-sweetalert/sweetalert.css') }}">
@stop

@section('body')

<div class="page">
    <div class="page-header">
        <h1 class="page-title">Permintaan Pembelian</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/manajer">Manajer</a></li>
            <li class="breadcrumb-item active">Persetujuan Permintaan Pembelian Bahan Baku</li>
        </ol>

    </div>
    <div class="page-content">
        <div class="panel">
            <header class="panel-heading">
                <div class="panel-actions"></div>
                <h3 class="panel-title"></h3>
            </header>
            <div class="panel-body">
               
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
<script src="{{ asset('global/vendor/bootstrap-sweetalert/sweetalert.js')}}"></script>
<script type="text/javascript">
    $(function() {
       
   

    })
</script>
@if(session('message'))
<script>
    toastr["success"]("{{ session('message') }}", "Success");
</script>
@endif
@stop