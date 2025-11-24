<!-- Modal Delete Staff -->
<div class="modal fade" id="deleteStaffModal" tabindex="-1" aria-labelledby="deleteStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%); color: white; border-radius: 15px 15px 0 0; border: none; padding: 1.5rem 2rem;">
                <h5 class="modal-title" id="deleteStaffModalLabel" style="font-weight: 600;">
                    <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <div class="text-center mb-4">
                    <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 4rem;"></i>
                </div>
                <h5 class="text-center mb-3">Yakin ingin menghapus staff ini?</h5>
                <p class="text-center text-muted mb-4">
                    Data yang dihapus tidak dapat dikembalikan. Pastikan Anda yakin dengan tindakan ini.
                </p>
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <p class="mb-1"><strong>Nama:</strong> <span id="delete_staff_name"></span></p>
                        <p class="mb-0"><strong>Email:</strong> <span id="delete_staff_email"></span></p>
                    </div>
                </div>
                <form id="formDeleteStaff">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="delete_staff_id" name="id">
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
    // Handle Submit Delete Staff
    document.getElementById('formDeleteStaff').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('delete_staff_id').value;
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menghapus...';
        
        fetch(`{{ route("owner.staff.destroy", ":id") }}`.replace(':id', id), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'Terjadi kesalahan');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Tampilkan notifikasi sukses
                showNotification('success', data.message || 'Staff berhasil dihapus.');
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteStaffModal'));
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

    // Reset form ketika modal ditutup
    document.getElementById('deleteStaffModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('formDeleteStaff').reset();
        const submitBtn = document.querySelector('#formDeleteStaff button[type="submit"]');
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Ya, Hapus';
    });
</script>
@endpush

