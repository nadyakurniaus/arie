@extends('back.layouts-finishing.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.min.css') }}">
@stop

@section('body')
<a href="{{ route('widget.finishing') }}">
<div class="page">
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-xl-6 col-lg-12 col-xs-12">
                <div class="row">
                <div class="col-lg-6 col-xs-12">
                    <div class="card card-block p-25">
                    <div class="counter counter-lg">
                    <span class="counter-number">{{$produksicount}}</span>
                        <div class="counter-label text-uppercase" style="color:black;">Menunggu Finishing</div>
                    </div>
                    </div>
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>
</div>
</div>
</a>

@stop
@section('script')
<script src="{{ asset('global/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>
<script type="text/javascript">
</script>
@if($errors->any())
<script>
    toastr["error"]("@foreach($errors->all() as $x) {{ $x }} <br> @endforeach", "Error");
</script>
@endif
@if(session('message'))
  <script>
      toastr["info"]("{{ session('message') }}", "Berhasil!");
  </script>
@endif
@stop
