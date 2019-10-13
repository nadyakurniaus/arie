<!-- Modal -->
<div class="modal fade modal-danger" id="delete-modal" aria-hidden="true" aria-labelledby="delete-modal" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Hapus <span class="delete-type"></span></h4>
            </div>
            <div class="modal-body">
                <p>
                    Apakah Anda yakin ingin menghapus data ini ?
                    <strong><span class="delete-hint badge badge-warning"></span></strong>?
                </p>
            </div>
            <div class="modal-footer">
                <form class="hiddenDeleteForm" method="POST">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" class="btn btn-danger btn-confirm-delete">
                        Hapus
                    </button>
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->