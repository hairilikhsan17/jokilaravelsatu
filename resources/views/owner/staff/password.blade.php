<!-- Modal Ubah Password Staff -->
<div class="modal fade" id="ubahPasswordStaffModal" tabindex="-1" aria-labelledby="ubahPasswordStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; border-radius: 15px 15px 0 0; border: none; padding: 1.5rem 2rem;">
                <h5 class="modal-title" id="ubahPasswordStaffModalLabel" style="font-weight: 600;">
                    <i class="bi bi-key me-2"></i>Ubah Password Staff
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <p class="mb-1"><strong>Nama:</strong> <span id="password_staff_name"></span></p>
                        <p class="mb-0"><strong>Email:</strong> <span id="password_staff_email"></span></p>
                    </div>
                </div>
                <form id="formUbahPasswordStaff">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="password_staff_id" name="id">
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="new_password" name="password" minlength="6" required>
                        <small class="text-muted">Minimal 6 karakter</small>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="password_confirmation" minlength="6" required>
                    </div>
                    <div class="d-flex gap-2 justify-content-end mt-4 pt-3" style="border-top: 1px solid #e0e0e0;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info">
                            <i class="bi bi-key"></i> Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Handle Ubah Password Staff
    document.getElementById('formUbahPasswordStaff').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('password_staff_id').value;
        const password = document.getElementById('new_password').value;
        const passwordConfirmation = document.getElementById('new_password_confirmation').value;
        
        if (password !== passwordConfirmation) {
            alert('Password dan konfirmasi password tidak sesuai!');
            return;
        }
        
        const formData = new FormData(this);
        formData.append('_method', 'PUT');
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Memproses...';
        
        fetch(`{{ route("owner.staff.password", ":id") }}`.replace(':id', id), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
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
                showNotification('success', data.message || 'Password berhasil diubah.');
                const modal = bootstrap.Modal.getInstance(document.getElementById('ubahPasswordStaffModal'));
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
    document.getElementById('ubahPasswordStaffModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('formUbahPasswordStaff').reset();
        const submitBtn = document.querySelector('#formUbahPasswordStaff button[type="submit"]');
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="bi bi-key"></i> Ubah Password';
    });
</script>
@endpush

