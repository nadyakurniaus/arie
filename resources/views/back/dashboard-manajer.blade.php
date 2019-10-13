@extends('back.layouts-manajer.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.min.css') }}">
@stop

@section('body')
<a href="{{ route('manajer.list2') }}">
<div class="page">
    <div class="page-content container-fluid">
        <div class="row" data-plugin="matchHeight" data-by-row="true">
            <div class="col-xs-12 col-xxl-4 col-lg-12">
                <div class="row h-full">
                    <div class="col-xxl-12 col-lg-6 col-xs-12" style="height:50%;">
                        <!-- Widget Sale Bar -->
                        <div class="card card-block p-30 bg-blue-600">
                            <div class="card-watermark darker font-size-60 m-15"><i class="icon wb-clipboard" aria-hidden="true"></i></div>
                                <div class="counter counter-md counter-inverse text-xs-left">
                                    <div class="counter-number-group">
                                        <span class="counter-number">{{$pembcount}}</span>
                                        <span class="counter-number-related text-capitalize">Permintaan</span>
                                    </div>
                                <div class="counter-label text-capitalize">Yang harus diapprove</div>
                            </div>
                        </div>
                        <!-- End Widget Sale Bar -->
                    </div>
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
