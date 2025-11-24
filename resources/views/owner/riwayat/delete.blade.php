<!-- Modal Hapus Riwayat Aktivitas -->
<div class="modal fade" id="deleteRiwayatModal" tabindex="-1" aria-labelledby="deleteRiwayatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%); color: white; border-radius: 15px 15px 0 0; border: none; padding: 1.5rem 2rem;">
                <h5 class="modal-title" id="deleteRiwayatModalLabel" style="font-weight: 600;">
                    <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <div class="text-center mb-4">
                    <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 4rem;"></i>
                </div>
                <h5 class="text-center mb-3">Yakin ingin menghapus riwayat aktivitas ini?</h5>
                <p class="text-center text-muted mb-4">
                    Data yang dihapus tidak dapat dikembalikan. Riwayat ini juga akan terhapus dari halaman staff terkait.
                </p>
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <p class="mb-1"><strong>Staff:</strong> <span id="delete_riwayat_staff"></span></p>
                        <p class="mb-1"><strong>Obat/Alkes:</strong> <span id="delete_riwayat_obat"></span></p>
                        <p class="mb-1"><strong>Jenis Aksi:</strong> <span id="delete_riwayat_aksi"></span></p>
                        <p class="mb-0"><strong>Tanggal:</strong> <span id="delete_riwayat_tanggal"></span></p>
                    </div>
                </div>
                <form id="formDeleteRiwayat">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="delete_riwayat_id" name="id">
                    <div class="d-flex gap-2 justify-content-end mt-4 pt-3" style="border-top: 1px solid #e0e0e0;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Handle Submit Delete Riwayat
    document.getElementById('formDeleteRiwayat').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('delete_riwayat_id').value;
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menghapus...';
        
        fetch(`{{ route("owner.riwayat.destroy", ":id") }}`.replace(':id', id), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('success', data.message || 'Riwayat aktivitas berhasil dihapus.');
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteRiwayatModal'));
                modal.hide();
                setTimeout(() => location.reload(), 500);
            } else {
                showNotification('error', data.message || 'Terjadi kesalahan');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan: ' + error.message);
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
</script>
@endpush

