@extends('back.layouts.base')

@section('style')

@stop

@section('body')
<!-- Page -->
<div class="page">
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-xl-6 col-lg-12 col-xs-12">
                <div class="row">
                <div class="col-lg-6 col-xs-12"><a href="/product">
                    <div class="card card-block p-25 bg-blue-600">

                            <div class="counter counter-lg counter-inverse">
                                <div class="counter-label text-uppercase">Produk Terdaftar</div>
                                <span class="counter-number">{{$prodcount}}</span>
                            </div>

                    </div></a>
                </div>
                <div class="col-lg-6 col-xs-12">
                    <a href="/listorder">
                    <div class="card card-block p-25 bg-purple-600">
                    <div class="counter counter-lg counter-inverse">
                        <div class="counter-label text-uppercase">Total Order</div>
                        <div class="counter-number-group">
                        <span class="counter-number">{{$penjcount}}</span>
                        </div>
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
