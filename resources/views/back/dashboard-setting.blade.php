@extends('back.layouts-setting.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.min.css') }}">
@stop

@section('body')
<a href="{{ route('manajer.list') }}">
<div class="page">
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-xl-6 col-lg-12 col-xs-12">
                <a href="{{ route('index.setting-dashboard') }}">
                <div class="card card-block p-30 bg-purple-600">
                    <div class="card-watermark lighter font-size-60 m-15"><i class="icon wb-image" aria-hidden="true"></i></div>
                    <div class="counter counter-md counter-inverse text-xs-left">
                      <div class="counter-number-wrap font-size-30">
                        <span class="counter-number">{{$designcount}}</span>
                        <span class="counter-number-related text-capitalize">design</span>
                      </div>
                      <div class="counter-label text-capitalize">Belum terinput</div>
                    </div>
                  </div>
                </a>
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
