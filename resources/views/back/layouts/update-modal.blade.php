<!-- Modal -->
<div class="modal fade modal-success" id="pembayaran-modal" aria-hidden="true" aria-labelledby="pembayaran-modal" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Input <span class="delete-type"></span></h4>
            </div>
            <div class="modal-body">
            <form class="form-pembayaran" method="POST">
                @method('PUT')

                <div class="form-group form-material" data-plugin="formMaterial"> 
                <input type="text" class="form-control" id="inputText" name="no_faktur" readonly/>
                </div>
                <div class="form-group form-material" data-plugin="formMaterial"> 
                    <input type="text" class="form-control" id="inputText" name="id_order" readonly/>
                </div>
                <div class="form-group form-material" data-plugin="formMaterial"> 
                    <input type="text" class="form-control" id="inputText" name="tanggal_order" readonly/>
                </div>
                <div class="form-group form-material" data-plugin="formMaterial"> 
                    <input type="text" class="form-control" id="inputText" name="tanggal_selesai" readonly/>
                </div>
                <div class="form-group form-material" data-plugin="formMaterial"> 
                    <input type="text" class="form-control" id="inputText" name="nama_pemesan" readonly/>
                </div>
                <table class="table table-bordered">
                        <tr><th>No</th><th>Nama Produk</th><th>Harga</th><th>quantity</th><th>Total Pembayaran</th></tr>
                        <tr>
                        <td></td>
                        <td><input type="text" class="form-control" id="inputText" name="nama_produk"
                         readonly/></td>
                        <td><input type="text" class="form-control" id="inputText" name="harga"
                         readonly/></td>
                         <td><input type="text" class="form-control" id="inputText" name="jumlah"
                            readonly/></td>
                        <td><input type="text" class="form-control" id="inputText" name="total_pembayaran"
                         readonly/></td>
                        </tr>
                    </table>
                    <div class="form-group form-material" data-plugin="formMaterial">
                            <label class="form-control-label" for="select">Select</label>
                            <select class="form-control" id="select">
                              <option value="Lunas">Lunas</option>
                              <option value="DP">DP</option>
                            </select>
                          </div>
                          <div class="form-group form-material" data-plugin="formMaterial"> 
                                <input type="text" class="form-control" id="inputText" name="uang_muka" placeholder="Uang Muka"
                                />
                            </div>
                            <div class="form-group form-material" data-plugin="formMaterial"> 
                                    <input type="text" class="form-control" id="inputText" name="sisa_pembayaran" placeholder="Sisa Pembayaran"
                                    />
                                </div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-success btn-confirm-update">
                        Simpan
                    </button>
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->