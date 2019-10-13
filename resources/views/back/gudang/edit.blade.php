@extends('back.layouts-gudang.base')

@section('style')

@stop

@section('body')

<div class="page">
    <div class="page-header">
      <h1 class="page-title">Bahan Baku</h1>
      <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="javascript:void(0)">Bagian Gudang</a></li>
             <li class="breadcrumb-item"><a href="javascript:void(0)">Kelola Bahan Baku</a></li>
             <li class="breadcrumb-item"><a href="javascript:void(0)">Bahan Baku</a></li>
            <li class="breadcrumb-item active">Ubah</li>
      </ol>
      <div class="page-header-actions">
          <form action="{{ route('bahanbaku.update', $bahan->id) }}" method="POST" autocomplete="off">
              <input name="_method" type="hidden" value="PATCH">
              @csrf
        <a href="{{ route('bahanbaku.index') }}" class="btn btn-md btn-icon btn-outline btn-warning btn-round"
            data-toggle="tooltip" data-original-title="Kembali ke Home">
            <i class="icon wb-arrow-left" aria-hidden="true"></i> &nbsp; Kembali
        </a>
        <button type="submit" class="btn btn-md btn-icon btn-primary btn-round" data-toggle="tooltip"
            data-original-title="Edit Bahan Baku">
            <i class="icon wb-check" aria-hidden="true"></i> &nbsp; Ubah
        </button>
    </div>
    </div>

    <div class="page-content container-fluid">
      <div class="row">
        <div class="col-lg-6 col-xs-12">
          <!-- Panel Static Labels -->
          <div class="panel">
            <div class="panel-heading">
             <h3 class="panel-title">Nama Bahan Baku</h3>
            </div>
            <div class="panel-body container-fluid">
                <div class="form-group form-material" data-plugin="formMaterial">
                  <label class="form-control-label" for="inputText">Bahan Baku</label>
                <input type="text" class="form-control" id="inputText" name="nama" placeholder="Nama Bahan Baku" value="{{$bahan->nama}}"
                  />
                </div>
                <div class="form-group form-material" data-plugin="formMaterial">
                    <label class="form-control-label" for="inputPassword">Jenis</label>
                    <div class="example">
                      <select name="jenis" class="form-control" data-plugin="selectpicker">
                         <option>- Pilih Salah Satu -</option>
                        <option>Kertas</option>
                        <option>Amplop</option>
                        <option>Kain</option>
                      </select>
                    </div>
                  </div>

            </div>
          </div>
          <!-- End Panel Floating Labels -->
        </div>
        <div class="col-lg-6 col-xs-12">
            <!-- Panel Static Labels -->
            <div class="panel">
              <div class="panel-heading">
                <h3 class="panel-title">Ukuran Bahan Baku</h3>
              </div>
              <div class="panel-body container-fluid">
                  <div class="form-group form-material" data-plugin="formMaterial">
                    <label class="form-control-label" for="inputPassword">Ukuran</label>
                    <input type="text" class="form-control" id="inputPassword" name="namaukuran"
                  placeholder="Masukan Ukuran" value="{{$ukuran->nama}}"/>
                  </div>
                    <div class="form-group form-material" data-plugin="formMaterial">
                    <label class="form-control-label" for="inputPassword">Stok</label>

                        <div class="input-group input-group-icon">
                            <input type="text" class="form-control" placeholder="Stok" name="stok" value="{{$ukuran->stok}}">
                            <span class="input-group-addon">
                                <span class="icon" aria-hidden="true">Pcs</span>
                            </span>
                        </div>
                    </div>
                    <div class="example">
                    <input type="hidden" class="form-control" id="inputPassword" name="satuan"
                    placeholder="Masukan stok" value="{{$ukuran->satuan}}"/>

                  </div>
                </form>
              </div>
            </div>
            <!-- End Panel Floating Labels -->
          </div>
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
