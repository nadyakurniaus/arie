@extends('back.layouts-gudang.base')

@section('style')

@stop

@section('body')

<div class="page">
    <div class="page-header">
      <h1 class="page-title">Tambah Bahan Baku</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Forms</a></li>
        <li class="breadcrumb-item active">Bahan Baku</li>
      </ol>
      <div class="page-header-actions">
        <a href="{{ route('bahanbaku.index') }}" class="btn btn-md btn-icon btn-outline btn-warning btn-round"
            data-toggle="tooltip" data-original-title="Go back to role index">
            <i class="icon wb-arrow-left" aria-hidden="true"></i> &nbsp; Go Back
        </a>
        <button type="submit" class="btn btn-md btn-icon btn-success btn-round" data-toggle="tooltip"
            data-original-title="Save community">
            <i class="icon wb-check" aria-hidden="true"></i> &nbsp; Save
        </button>
    </div>
    </div>
    
    <div class="page-content container-fluid">
      <div class="row">
        <div class="col-lg-8 offset-lg-2 col-xs-12">
          <!-- Panel Static Labels -->
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">Tambah Bahan Baku</h3>
            </div>
            <div class="panel-body container-fluid">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
              @endif
              <form action="{{ route('bahanbaku.store') }}" method="POST" autocomplete="off">
                  @csrf
                <div class="form-group form-material" data-plugin="formMaterial">
                  <label class="form-control-label" for="inputText">Bahan Baku</label>
                  <input type="text" class="form-control" id="inputText" name="nama" placeholder="Nama Bahan Baku"
                  />
                </div>
                <div class="form-group form-material" data-plugin="formMaterial">
                    <label class="form-control-label" for="inputPassword">Jenis</label>
                    <div class="example">
                      <select name="jenis" class="form-control" data-plugin="selectpicker">
                        <option>Kertas</option>
                        <option>Amplop</option>
                        <option>Kain</option>
                      </select>
                    </div>
                  </div>
                <div class="form-group form-material" data-plugin="formMaterial">
                  <label class="form-control-label" for="inputPassword">Ukuran</label>
                  <input type="text" class="form-control" id="inputPassword" name="ukuran"
                  placeholder="Masukan Ukuran" />
                </div>
                <div class="form-group form-material" data-plugin="formMaterial">
                    <label class="form-control-label" for="inputPassword">Stok</label>
                    <input type="text" class="form-control" id="inputPassword" name="stok"
                    placeholder="Masukan stok" />
                  </div>
                <div class="form-group form-material" data-plugin="formMaterial">
                  <label class="form-control-label" for="inputPassword">Satuan</label>
                  <div class="example">
                    <select name="socmed" class="form-control" data-plugin="selectpicker">
                      <option>rim</option>
                      <option>pack</option>
                      <option>pcs</option>
                    </select>
                  </div>
                </div>
                    <div>
                    <span class="input-group-btn">
                      <button class="btn btn-info" type="submit" name="simpan">Tambah Bahan Baku</button>
                    </span>
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

@stop
