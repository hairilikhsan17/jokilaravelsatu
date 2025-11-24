<!-- Modal Tambah Staff -->
<div class="modal fade" id="tambahStaffModal" tabindex="-1" aria-labelledby="tambahStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0; border: none; padding: 1.5rem 2rem;">
                <h5 class="modal-title" id="tambahStaffModalLabel" style="font-weight: 600;">
                    <i class="bi bi-person-plus me-2"></i>Tambah Staff
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <form id="formTambahStaff">
                    @csrf
                    <div class="mb-3">
                        <label for="staff_name" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="staff_name" name="name" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="staff_email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="staff_email" name="email" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="staff_password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="staff_password" name="password" minlength="6" required>
                        <small class="text-muted">Minimal 6 karakter</small>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="staff_role" class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-select" id="staff_role" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="staff">Staff</option>
                            <option value="admin">Admin</option>
                            <option value="owner">Owner</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="staff_is_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="staff_is_active">
                                Status Aktif
                            </label>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-end mt-4 pt-3" style="border-top: 1px solid #e0e0e0;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Staff -->
<div class="modal fade" id="editStaffModal" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white; border-radius: 15px 15px 0 0; border: none; padding: 1.5rem 2rem;">
                <h5 class="modal-title" id="editStaffModalLabel" style="font-weight: 600;">
                    <i class="bi bi-pencil-square me-2"></i>Edit Staff
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <form id="formEditStaff">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_staff_id" name="id">
                    <div class="mb-3">
                        <label for="edit_staff_name" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_staff_name" name="name" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_staff_email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="edit_staff_email" name="email" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_staff_role" class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_staff_role" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="staff">Staff</option>
                            <option value="admin">Admin</option>
                            <option value="owner">Owner</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_staff_is_active" class="form-label">Status Aktif <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_staff_is_active" name="is_active" required style="width: 100%;">
                            <option value="1">Aktif</option>
                            <option value="0">Non-Aktif</option>
                        </select>
                        <small class="text-muted d-block mt-1">
                            <i class="bi bi-info-circle"></i> Pilih <strong>Aktif</strong> untuk mengizinkan staff login, atau <strong>Non-Aktif</strong> untuk menonaktifkan akses login staff.
                        </small>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="d-flex gap-2 justify-content-end mt-4 pt-3" style="border-top: 1px solid #e0e0e0;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Handle Tambah Staff
    document.getElementById('formTambahStaff').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        
        // Handle is_active checkbox
        const isActiveCheckbox = form.querySelector('#staff_is_active');
        if (isActiveCheckbox && isActiveCheckbox.checked) {
            formData.set('is_active', '1');
        } else {
            formData.set('is_active', '0');
        }
        
        // Reset validation
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        
        fetch('{{ route("owner.staff.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Tampilkan notifikasi sukses
                showNotification('success', data.message || 'Staff berhasil ditambahkan.');
                const modal = bootstrap.Modal.getInstance(document.getElementById('tambahStaffModal'));
                modal.hide();
                setTimeout(() => location.reload(), 500);
            } else {
                // Tampilkan error validasi
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        const input = form.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add('is-invalid');
                            const feedback = input.nextElementSibling;
                            if (feedback && feedback.classList.contains('invalid-feedback')) {
                                feedback.textContent = data.errors[field][0];
                            }
                        }
                    });
                } else {
                    showNotification('error', data.message || 'Terjadi kesalahan');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan: ' + error.message);
        });
    });

    // Handle Edit Staff
    document.getElementById('formEditStaff').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const id = document.getElementById('edit_staff_id').value;
        const formData = new FormData(form);
        
        // Handle is_active select dropdown
        const isActiveSelect = form.querySelector('#edit_staff_is_active');
        if (isActiveSelect) {
            formData.set('is_active', isActiveSelect.value);
        }
        
        formData.append('_method', 'PUT');
        
        // Reset validation
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        
        fetch(`{{ route("owner.staff.update", ":id") }}`.replace(':id', id), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Tampilkan notifikasi sukses
                showNotification('success', data.message || 'Staff berhasil diperbarui.');
                const modal = bootstrap.Modal.getInstance(document.getElementById('editStaffModal'));
                modal.hide();
                setTimeout(() => location.reload(), 500);
            } else {
                // Tampilkan error validasi
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        const input = form.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add('is-invalid');
                            const feedback = input.nextElementSibling;
                            if (feedback && feedback.classList.contains('invalid-feedback')) {
                                feedback.textContent = data.errors[field][0];
                            }
                        }
                    });
                } else {
                    showNotification('error', data.message || 'Terjadi kesalahan');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan: ' + error.message);
        });
    });
</script>
@endpush
