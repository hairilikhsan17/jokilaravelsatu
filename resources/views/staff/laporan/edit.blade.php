<!-- Modal Edit Laporan -->
<div class="modal fade" id="editLaporanModal" tabindex="-1" aria-labelledby="editLaporanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white; border-radius: 15px 15px 0 0; border: none; padding: 1.5rem 2rem;">
                <h5 class="modal-title" id="editLaporanModalLabel" style="font-weight: 600;">
                    <i class="bi bi-pencil-square me-2"></i>Edit Laporan Stok
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <form id="formEditLaporan">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_laporan_id" name="id">
                    <div class="mb-3">
                        <label for="edit_id_obat" class="form-label">Obat/Alkes <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_id_obat" name="id_obat" required>
                            <option value="">Pilih Obat/Alkes</option>
                            @foreach($obatAlkes as $obat)
                                <option value="{{ $obat->id }}" data-stok="{{ $obat->stok }}">
                                    {{ $obat->nama }} ({{ $obat->kategori }}) - Stok: {{ $obat->stok }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                        <small class="text-muted">Pilih obat/alkes yang akan dilaporkan</small>
                    </div>
                    <div class="mb-3">
                        <label for="edit_jumlah" class="form-label">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="edit_jumlah" name="jumlah" min="1" required>
                        <div class="invalid-feedback"></div>
                        <small class="text-muted">Masukkan jumlah yang dilaporkan (minimal 1)</small>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="edit_tanggal" name="tanggal" required>
                        <div class="invalid-feedback"></div>
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
    // Handle Edit Laporan
    function editLaporan(id) {
        fetch(`{{ route("staff.laporan.edit", ":id") }}`.replace(':id', id), {
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
            document.getElementById('edit_laporan_id').value = data.id;
            document.getElementById('edit_id_obat').value = data.id_obat;
            document.getElementById('edit_jumlah').value = data.jumlah;
            // Format tanggal untuk input date (YYYY-MM-DD)
            const tanggal = new Date(data.tanggal);
            document.getElementById('edit_tanggal').value = tanggal.toISOString().split('T')[0];
            document.getElementById('edit_keterangan').value = data.keterangan || '';
            
            const modal = new bootstrap.Modal(document.getElementById('editLaporanModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan saat mengambil data: ' + error.message);
        });
    }

    // Handle Update Laporan
    document.getElementById('formEditLaporan').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const id = document.getElementById('edit_laporan_id').value;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        formData.append('_method', 'PUT');
        
        // Reset validation
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        
        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Memperbarui...';
        
        fetch(`{{ route("staff.laporan.update", ":id") }}`.replace(':id', id), {
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
                showNotification('success', data.message || 'Laporan stok berhasil diperbarui.');
                const modal = bootstrap.Modal.getInstance(document.getElementById('editLaporanModal'));
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
    document.getElementById('editLaporanModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('formEditLaporan').reset();
        document.getElementById('formEditLaporan').querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    });
</script>
@endpush

