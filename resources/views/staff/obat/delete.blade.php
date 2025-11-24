<!-- Modal Hapus Obat -->
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
                    Data yang dihapus tidak dapat dikembalikan.
                </p>
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <p class="mb-1"><strong>Nama:</strong> <span id="delete_obat_nama"></span></p>
                        <p class="mb-1"><strong>Kategori:</strong> <span id="delete_obat_kategori"></span></p>
                        <p class="mb-1"><strong>Stok:</strong> <span id="delete_obat_stok"></span></p>
                        <p class="mb-0"><strong>Supplier:</strong> <span id="delete_obat_supplier"></span></p>
                    </div>
                </div>
                <form id="formDeleteObat">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="delete_obat_id" name="id">
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
    function deleteObat(id) {
        fetch(`{{ route("staff.obat.edit", ":id") }}`.replace(':id', id), {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Gagal mengambil data');
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('delete_obat_id').value = data.id;
            document.getElementById('delete_obat_nama').textContent = data.nama || '-';
            document.getElementById('delete_obat_kategori').textContent = data.kategori || '-';
            document.getElementById('delete_obat_stok').textContent = data.stok || '0';
            document.getElementById('delete_obat_supplier').textContent = data.supplier || '-';
            
            const modal = new bootstrap.Modal(document.getElementById('deleteObatModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan saat mengambil data: ' + error.message);
        });
    }

    // Handle Submit Delete Obat
    document.getElementById('formDeleteObat').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('delete_obat_id').value;
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menghapus...';
        
        fetch(`{{ route("staff.obat.destroy", ":id") }}`.replace(':id', id), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('success', data.message || 'Data berhasil dihapus.');
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteObatModal'));
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

