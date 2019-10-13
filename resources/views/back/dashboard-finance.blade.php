@extends('back.layouts-finance.base')

@section('style')

@stop

@section('body')
<!-- Page -->
<div class="page">
    <div class="page-content container-fluid">
        <div class="row" data-plugin="matchHeight" data-by-row="true">
            <div class="col-xs-12 col-xxl-4 col-lg-12">
                <div class="row h-full">
                    <div class="col-xs-12 col-xxl-12 col-lg-6" style="height:50%;">
                       <a href="{{route('widget.finance')}}"> <div class="card card-block p-35 clearfix">
                            <div class="pull-xs-left white">
                              <i class="icon icon-circle icon-2x wb-clipboard bg-red-600" aria-hidden="true"></i>
                            </div>
                            <div class="counter counter-md counter text-xs-right pull-xs-right">
                              <div class="counter-number-group">
                                <span class="counter-number">{{$pemcount}}</span>
                                <span class="counter-number-related text-capitalize">Pembayaran</span>
                              </div>
                              <div class="counter-label text-capitalize font-size-16" style="color:black;">Status: Belum Lunas</div>
                            </div>
                          </div></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Page -->
@stop

@section('script')
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
