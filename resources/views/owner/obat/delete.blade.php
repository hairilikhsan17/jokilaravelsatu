<!-- Modal Delete Obat -->
<div class="modal fade" id="deleteObatModal" tabindex="-1" aria-labelledby="deleteObatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%); color: white; border-radius: 15px 15px 0 0; border: none; padding: 1.5rem 2rem;">
                <h5 class="modal-title" id="deleteObatModalLabel" style="font-weight: 600;">
                    <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <div class="text-center mb-4">
                    <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 4rem;"></i>
                </div>
                <h5 class="text-center mb-3">Yakin ingin menghapus data ini?</h5>
                <p class="text-center text-muted mb-4">
                    Data yang dihapus tidak dapat dikembalikan. Pastikan Anda yakin dengan tindakan ini.
                </p>
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <p class="mb-1"><strong>Nama:</strong> <span id="delete_nama"></span></p>
                        <p class="mb-1"><strong>Kategori:</strong> <span id="delete_kategori"></span></p>
                        <p class="mb-0"><strong>Stok:</strong> <span id="delete_stok"></span></p>
                    </div>
                </div>
                <form id="formDeleteObat">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="delete_id" name="id">
                    <div class="d-flex gap-2 justify-content-end mt-4 pt-3" style="border-top: 1px solid #e0e0e0;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

