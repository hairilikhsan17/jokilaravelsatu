<!-- Modal Edit Riwayat Aktivitas -->
<div class="modal fade" id="editRiwayatModal" tabindex="-1" aria-labelledby="editRiwayatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white; border-radius: 15px 15px 0 0; border: none; padding: 1.5rem 2rem;">
                <h5 class="modal-title" id="editRiwayatModalLabel" style="font-weight: 600;">
                    <i class="bi bi-pencil-square me-2"></i>Edit Riwayat Aktivitas
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <form id="formEditRiwayat">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_riwayat_id" name="id">
                    <div class="mb-3">
                        <label for="edit_id_staff" class="form-label">Staff <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_id_staff" name="id_staff" required>
                            <option value="">Pilih Staff</option>
                            @foreach($staffList as $staff)
                                <option value="{{ $staff->id }}">
                                    {{ $staff->name }} ({{ ucfirst($staff->role) }})
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_id_obat" class="form-label">Obat/Alkes <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_id_obat" name="id_obat" required>
                            <option value="">Pilih Obat/Alkes</option>
                            @foreach($obatAlkes as $obat)
                                <option value="{{ $obat->id }}">
                                    {{ $obat->nama }} ({{ $obat->kategori }})
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_jenis_aksi" class="form-label">Jenis Aksi <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_jenis_aksi" name="jenis_aksi" required>
                            <option value="">Pilih Jenis Aksi</option>
                            <option value="tambah">Tambah</option>
                            <option value="update">Edit</option>
                            <option value="hapus">Hapus</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="edit_tanggal" name="tanggal" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_waktu" class="form-label">Waktu <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" id="edit_waktu" name="waktu" required>
                            <div class="invalid-feedback"></div>
                            <small class="text-muted">Waktu akan digabungkan dengan tanggal</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="3" placeholder="Masukkan keterangan (opsional)" maxlength="500"></textarea>
                        <small class="text-muted">Maksimal 500 karakter</small>
                    </div>
                    <div class="d-flex gap-2 justify-content-end mt-4 pt-3" style="border-top: 1px solid #e0e0e0;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Handle Update Riwayat
    document.getElementById('formEditRiwayat').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const id = document.getElementById('edit_riwayat_id').value;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        // Gabungkan tanggal dan waktu
        const tanggal = formData.get('tanggal');
        const waktu = formData.get('waktu');
        formData.delete('waktu');
        formData.set('tanggal', tanggal + ' ' + waktu + ':00');
        
        formData.append('_method', 'PUT');
        
        // Reset validation
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        
        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Memperbarui...';
        
        fetch(`{{ route("owner.riwayat.update", ":id") }}`.replace(':id', id), {
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
                showNotification('success', data.message || 'Riwayat aktivitas berhasil diperbarui.');
                const modal = bootstrap.Modal.getInstance(document.getElementById('editRiwayatModal'));
                modal.hide();
                setTimeout(() => location.reload(), 500);
            } else {
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
    document.getElementById('editRiwayatModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('formEditRiwayat').reset();
        document.getElementById('formEditRiwayat').querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    });
</script>
@endpush

