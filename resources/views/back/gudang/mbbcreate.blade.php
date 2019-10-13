@extends('back.layouts-gudang.base')

@section('style')

@stop

@section('body')

<div class="page">
    <div class="page-header">
      <h1 class="page-title">Monitoring Bahan Baku</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Bagian Gudang</a></li>
             <li class="breadcrumb-item"><a href="javascript:void(0)">Kelola Bahan Baku</a></li>
             <li class="breadcrumb-item"><a href="javascript:void(0)">Monitoring Bahan Baku</a></li>
            <li class="breadcrumb-item active">Tambah</li>
      </ol>
      <div class="page-header-actions">
        <form action="{{ route('monitoring.simpan', $bahan->id) }}" method="POST" autocomplete="off">
                    @csrf
        <a href="{{ route('bahanbaku.index') }}" class="btn btn-md btn-icon btn-outline btn-warning btn-round"
            data-toggle="tooltip" data-original-title="Go back to role index">
            <i class="icon wb-arrow-left" aria-hidden="true"></i> &nbsp; Kembali
        </a>
        <button type="submit" class="btn btn-md btn-icon btn-primary btn-round" data-toggle="tooltip"
            data-original-title="Save community">
            <i class="icon wb-check" aria-hidden="true"></i> &nbsp; Simpan
        </button>
    </div>
    </div>
    
    <div class="page-content container-fluid">
      <div class="row">
        <div class="col-lg-7  col-xs-12">
          <!-- Panel Static Labels -->
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">Monitoring Bahan Baku</h3>
            </div>
            <div class="panel-body container-fluid">
              
                <div class="form-group form-material" data-plugin="formMaterial">
                  <label class="form-control-label" for="inputText">Bahan Baku</label>
                <input type="text" class="form-control" id="inputText" name="nama" placeholder="Nama Bahan Baku" value="{{$bahan->nama}}"
                  readonly/>
                </div>
                <div class="form-group form-material" data-plugin="formMaterial">
                    <label class="form-control-label" for="inputText">Jenis</label>
                <input type="text" class="form-control" id="inputText" name="nama" placeholder="Nama Bahan Baku" value="{{$bahan->jenis}}"
                  readonly/>
                  </div>
                <div class="form-group form-material" data-plugin="formMaterial">
                  <label class="form-control-label" for="inputPassword">Ukuran</label>
                  <input type="text" class="form-control" id="inputPassword" name="namaukuran"
                placeholder="Masukan Ukuran" value="{{$ukuran->nama}}" readonly/>
                </div>
                <div class="form-group form-material" data-plugin="formMaterial">
                    <label class="form-control-label" for="inputPassword">Stok</label>
                    <input type="text" class="form-control" id="inputPassword" name="stok"
                placeholder="Masukan stok" value="{{$ukuran->stok}}" readonly/>
                  </div>
                <div class="form-group form-material" data-plugin="formMaterial">
                  <label class="form-control-label" for="inputText"> Ukuran</label>
                <input type="text" class="form-control" id="inputText" name="nama" placeholder="Nama Bahan Baku" value="{{$ukuran->satuan}}"
                  readonly/>

                </div>
            </div>
          </div>
          <!-- End Panel Floating Labels -->
        </div>
        <div class="col-lg-5 col-xs-12">
                <!-- Panel Static Labels -->
                <div class="panel">
               
                  <div class="panel-body container-fluid">
                      <div class="form-group form-material" data-plugin="formMaterial">
                          <label class="form-control-label" for="inputPassword">Minimal Stok</label>
                          <input type="text" class="form-control" id="inputPassword" name="minimum"
                             placeholder="Masukan minimal stok" />
                        </div>
                  </div>
                </div>
                <!-- End Panel Floating Labels -->
              </div>
            </form>
      </div>
    </div>
  </div>


@stop

@section('script')
@if($errors->any())
  <script>
      toastr["error"]("@foreach($errors->all() as $x) {{ $x }} <br> @endforeach", "Error");
  </script>
@endif
@if(session('message'))
    <script>
        toastr["info"]("{{ session('message') }}", "Success");
    </script>
@endif
@stop
