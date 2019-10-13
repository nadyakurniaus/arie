@extends('back.layouts.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/select2/select2.min.css') }}">
@stop

@section('body')

<div class="page">
  <div class="page-header">
    <h1 class="page-title">Tambah Produk</h1>
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="/bagsetting">Admin</a></li>
            <li class="breadcrumb-item"><a href="/setting">Kelola Produk</a></li>
              <li class="breadcrumb-item"><a href="/setting">Produk</a></li>
            <li class="breadcrumb-item active">Tambah</li>
    </ol>
    <div class="page-header-actions">
        <form action="{{ route('product.store')}}" method="POST" autocomplete="off" data-parsley-validate="">
            @csrf
      <a href="{{ route('produk.index') }}" class="btn btn-md btn-icon btn-outline btn-warning btn-round" data-toggle="tooltip" data-original-title="Go back to role index">
        <i class="icon wb-arrow-left" aria-hidden="true"></i> &nbsp; Kembali
      </a>
      <button type="submit" class="btn btn-md btn-icon btn-primary btn-round" data-toggle="tooltip" data-original-title="Save">
        <i class="icon wb-check" aria-hidden="true"></i> &nbsp; Simpan
      </button>
    </div>
  </div>

  <div class="page-content container-fluid">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 col-xs-12">
        <!-- Panel Static Labels -->
        <div class="panel">
          <div class="panel-heading">
            <h3 class="panel-title">Form Tambah Produk</h3>
          </div>
          <div class="panel-body container-fluid">
              <div class="form-group form-material" data-plugin="formMaterial">
                  <label class="label" for="inputText">ID Produk</label>
              <input type="text" class="form-control"  name="idProduk" value="{{$kodeproduk}}" readonly/>
              </div>
              <div class="form-group form-material" data-plugin="formMaterial">
                  <label class="label" for="inputText">Nama Produk</label>
                  {!! Form::text('nama', null, [
                      'class'                         => 'form-control',
                      'required',
                      'id'                            => 'inputProduk',
                      'data-parsley-required-message' => 'Produk harus diisi',
                      'data-parsley-trigger'          => 'change focusout',
                      'maxlength'                     => '30',
                      'data-parsley-maxlength'        => '30',
                      'data-parsley-type'             => 'text'
                  ]) !!}
              </div>
              <div class="form-group form-material" data-plugin="formMaterial">
                <label class="label" for="inputText">Bahan Baku</label>

                <select name="id_bahan" id="bahan_id" class="form-control">
                        <option></option>
                        @foreach( $data as $value)
                            <option value="{{$value->id}}">{{$value->nama}} ({{$value->namaukuran}})</option>
                        @endforeach
                </select>

              </div>
              <div class="form-group form-material" data-plugin="formMaterial">
                <label class="label" for="inputText">Ukuran Bahan</label>
                <select name="id_ukuran" id="ukuran_id" class="form-control select2">
                </select>
              </div>
              <div class="form-group form-material" data-plugin="formMaterial">
                <label class="label" for="inputText">Kebutuhan</label>
                <select name="kebutuhan" id="kebutuhan" class="form-control select2">
                     <option value="Identitas Perusahaan">- Pilih Salah Satu -</option>
                  <option value="Identitas Perusahaan">Identitas Perusahaan</option>
                  <option value="Media Promosi">Media Promosi</option>
                  <option value="Kartu">Kartu</option>
                </select>
              </div>
              <div class="form-group form-material" data-plugin="formMaterial">
                  <label class="label" for="inputText">Jenis Cetak</label>
                <select name="jenis_cetak" id="jenis_cetak" class="form-control select2">
                    <option value="Identitas Perusahaan">- Pilih Salah Satu -</option>
                  <option value="Digital Printing">Digital Printing</option>
                  <option value="Offset">Offset</option>
                </select>
              </div>
            <div class="form-group form-material" data-plugin="formMaterial">
              <label class="label" for="inputText">Sisi Cetak</label>
            <input type="text" class="form-control"  name="sisi_cetak" required/>
          </div>
          <div class="form-group form-material" data-plugin="formMaterial">
              <label class="label" for="inputText"><strong>Detail Harga :</strong></label>
          </div>
          {!! Form::open(['url' => 'product', 'files' => true, 'role' => 'form', 'class' => 'form-loading-button', 'data-parsley-validate' => '']) !!}
          <div class="table-responsive" id="tableManual">
              <table class="table table-bordered" id="items">
                  <thead>
                      <tr style="background-color: #f9f9f9;">
                          <th width="3%" class="text-center">Aksi</th>
                          <th width="10%" class="text-left">Quantity</th>
                          <th width="10%" class="text-left">Harga</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr id="item-row-0">
                          <td class="text-center" style="vertical-align: middle;">
                              <button type="button" onclick="$(this).tooltip('destroy'); $('#item-row-0').remove(); totalItem();" data-toggle="tooltip" title="Hapus" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                          </td>
                          <td>
                              <input value="" class="form-control typeahead" placeholder="Masukkan Quantity " name="item[0][qty]" type="text" id="item-qty-0" autocomplete="off" required>
                              <input value="" name="item[0][item_id]" type="hidden" id="item-id-0">

                          </td>
                          <td>
                              <input value="" class="form-control typeahead" placeholder="Masukkan Harga " name="item[0][harga]" type="text" id="item-harga-0" autocomplete="off" required>
                              <input value="" name="item[0][item_harga]" type="hidden" id="item-id-harga-0">
                          </td>
                      </tr>
                      <tr id="addItem">
                          <td class="text-center"><button type="button" id="button-add-item" data-toggle="tooltip" title="Menambahkan" class="btn btn-xs btn-primary" data-original-title="Menambahkan"><i class="fa fa-plus"></i></button></td>
                          <td class="text-right" colspan="5"></td>
                      </tr>
                  </tbody>
              </table>
          </div>
          {!! Form::close() !!}

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
<script src="{{ asset('global/js/Plugin/material.js') }}"></script>
<script src="{{ asset('js/select2Ajax.js') }}"></script>
<script src="{{ asset('js/selectBy.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script src="{{ asset('global/vendor/select2/select2.min.js') }}"></script>
<script>
  var autocomplete_path = "{{ route('produk.autocomplete') }}";
  var item_row = '1';
  var row_data = '0';
  $(document).ready(function() {
    $('#tableManual').removeAttr('hidden');
    $('#hidden').attr('hidden', '');
  });
  $(document).on('click', '.form-control.typeahead', function() {
        input_id = $(this).attr('id').split('-');

        item_id = parseInt(input_id[input_id.length - 1]);
        globalId = item_id;
        $(this).typeahead({
            minLength: 3,
            displayText: function(data) {
                return data.nama + ' (' + data.namaukuran + ')';
            },
            source: function(query, process) {
                $.ajax({
                    url: autocomplete_path,
                    type: 'GET',
                    dataType: 'JSON',
                    data: 'query=' + query,
                    success: function(data) {
                        return process(data);
                    }
                });
            },
            afterSelect: function(data) {
                $('#item-id-' + item_id).val(data.id);
                $('#item-quantity-' + item_id).val('1');
                $('#item-jenis-' + item_id).html(data.jenis);
                $('#item-jenis-' + item_id).html(data.jenis);
                $('#item-id-jenis-' + item_id).val(data.jenis);
                $('#item-total-' + item_id).html(data.total);
                $('#item_ukuran_' + item_id).select2(select2Ajax('Select', '{{ route("ppbb.select2") }}', 1));
                $('#item_satuan_' + item_id).select2();
                var das = $('#item-id-' + globalId).val()
                selectSatuan(das);
                totalItem();
            }
        });
    });
  $(document).on('click', '#button-add-item', function(e) {
        $.ajax({
            url: '{{ route("produk.add.harga") }}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                item_row: item_row,
            },
            success: function(json) {
                if (json['success']) {
                    $('#items tbody #addItem').before(json['html']);
                    $('[data-toggle="tooltip"]').tooltip('hide');
                    saveDetail();
                    item_row++;
                    row_data++;
                }
            }
        });
    });

    $('#cekdata').click(() => {
        saveDetail();
    });
    function saveDetail() {
        $.ajax({
            url: '{{ route("produk.save.harga") }}',
            type: 'POST',
            dataType: 'JSON',
            data: {
                'qty': $('#item-qty-' + row_data).val(),
                'harga': $('#item-harga-' + row_data).val()
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(data) {
                console.log(data);
            }
        });
    }
  $(function() {
    $('#ukuran_id').select2(getData('Select', '{{ route("produkukuran.select2") }}', 1));
    $('#jenis_cetak').select2();
    $('#kebutuhan').select2();
    $('#bahan_id').select2({
        placeholder: "Pilih Bahan Baku",
    allowClear: true
    });
  })
</script>
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
