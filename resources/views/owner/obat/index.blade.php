@extends('layouts.owner')

@section('title', 'Daftar Obat')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Daftar Obat</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahObatModal">
        <i class="bi bi-plus-circle"></i> Tambah Obat
    </button>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Expired Date</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($obats as $obat)
                        <tr>
                            <td>{{ $loop->iteration + ($obats->currentPage() - 1) * $obats->perPage() }}</td>
                            <td>{{ $obat->kode }}</td>
                            <td>{{ $obat->nama }}</td>
                            <td>{{ $obat->satuan }}</td>
                            <td>{{ $obat->stok }}</td>
                            <td>Rp {{ number_format($obat->harga_beli ?? 0, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($obat->harga_jual ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $obat->expired_date ? $obat->expired_date->format('d/m/Y') : '-' }}</td>
                            <td>
                                <button type="button" 
                                        class="btn btn-sm btn-warning" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editObatModal"
                                        data-obat-id="{{ $obat->id }}"
                                        data-obat-nama="{{ $obat->nama }}"
                                        data-obat-kode="{{ $obat->kode }}"
                                        data-obat-satuan="{{ $obat->satuan }}"
                                        data-obat-stok="{{ $obat->stok }}"
                                        data-obat-harga-beli="{{ $obat->harga_beli }}"
                                        data-obat-harga-jual="{{ $obat->harga_jual }}"
                                        data-obat-expired-date="{{ $obat->expired_date ? $obat->expired_date->format('Y-m-d') : '' }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('owner.obat.destroy', $obat) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data obat</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $obats->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah Obat -->
<div class="modal fade" id="tambahObatModal" tabindex="-1" aria-labelledby="tambahObatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2); overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0; border: none; padding: 1.5rem 2rem;">
                <h5 class="modal-title" id="tambahObatModalLabel" style="font-weight: 600; font-size: 1.25rem;">
                    <i class="bi bi-capsule-pill me-2"></i>Tambah Obat Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="opacity: 0.8;"></button>
            </div>
            <div class="modal-body" style="padding: 2rem; max-height: 70vh; overflow-y: auto;">
                <form id="formTambahObat" action="{{ route('owner.obat.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modal_nama" class="form-label">Nama Obat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                   id="modal_nama" name="nama" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="modal_kode" class="form-label">Kode Obat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kode') is-invalid @enderror" 
                                   id="modal_kode" name="kode" value="{{ old('kode') }}" required>
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modal_satuan" class="form-label">Satuan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('satuan') is-invalid @enderror" 
                                   id="modal_satuan" name="satuan" value="{{ old('satuan') }}" required>
                            @error('satuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="modal_stok" class="form-label">Stok Awal <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                                   id="modal_stok" name="stok" value="{{ old('stok', 0) }}" min="0" required>
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modal_harga_beli" class="form-label">Harga Beli</label>
                            <input type="number" class="form-control @error('harga_beli') is-invalid @enderror" 
                                   id="modal_harga_beli" name="harga_beli" value="{{ old('harga_beli') }}" min="0" step="0.01">
                            @error('harga_beli')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="modal_harga_jual" class="form-label">Harga Jual</label>
                            <input type="number" class="form-control @error('harga_jual') is-invalid @enderror" 
                                   id="modal_harga_jual" name="harga_jual" value="{{ old('harga_jual') }}" min="0" step="0.01">
                            @error('harga_jual')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="modal_expired_date" class="form-label">Tanggal Expired</label>
                        <input type="date" class="form-control @error('expired_date') is-invalid @enderror" 
                               id="modal_expired_date" name="expired_date" value="{{ old('expired_date') }}">
                        @error('expired_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-4 pt-3" style="border-top: 1px solid #e0e0e0;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="min-width: 100px;">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary" style="min-width: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                            <i class="bi bi-check-circle me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Obat -->
<div class="modal fade" id="editObatModal" tabindex="-1" aria-labelledby="editObatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2); overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white; border-radius: 15px 15px 0 0; border: none; padding: 1.5rem 2rem;">
                <h5 class="modal-title" id="editObatModalLabel" style="font-weight: 600; font-size: 1.25rem;">
                    <i class="bi bi-pencil-square me-2"></i>Edit Obat
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="opacity: 0.8;"></button>
            </div>
            <div class="modal-body" style="padding: 2rem; max-height: 70vh; overflow-y: auto;">
                <form id="formEditObat" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_obat_id" name="obat_id" value="{{ old('obat_id') }}">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_nama" class="form-label">Nama Obat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                   id="edit_nama" name="nama" value="{{ old('nama', '') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_kode" class="form-label">Kode Obat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kode') is-invalid @enderror" 
                                   id="edit_kode" name="kode" value="{{ old('kode', '') }}" required>
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_satuan" class="form-label">Satuan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('satuan') is-invalid @enderror" 
                                   id="edit_satuan" name="satuan" value="{{ old('satuan', '') }}" required>
                            @error('satuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_stok" class="form-label">Stok <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                                   id="edit_stok" name="stok" value="{{ old('stok', '') }}" min="0" required>
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_harga_beli" class="form-label">Harga Beli</label>
                            <input type="number" class="form-control @error('harga_beli') is-invalid @enderror" 
                                   id="edit_harga_beli" name="harga_beli" value="{{ old('harga_beli', '') }}" min="0" step="0.01">
                            @error('harga_beli')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_harga_jual" class="form-label">Harga Jual</label>
                            <input type="number" class="form-control @error('harga_jual') is-invalid @enderror" 
                                   id="edit_harga_jual" name="harga_jual" value="{{ old('harga_jual', '') }}" min="0" step="0.01">
                            @error('harga_jual')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_expired_date" class="form-label">Tanggal Expired</label>
                        <input type="date" class="form-control @error('expired_date') is-invalid @enderror" 
                               id="edit_expired_date" name="expired_date" value="{{ old('expired_date', '') }}">
                        @error('expired_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-4 pt-3" style="border-top: 1px solid #e0e0e0;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="min-width: 100px;">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary" style="min-width: 120px; background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); border: none;">
                            <i class="bi bi-check-circle me-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom scrollbar untuk modal body */
    .modal-body::-webkit-scrollbar {
        width: 6px;
    }
    .modal-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .modal-body::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
    }
    .modal-body::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }

    /* Animasi modal */
    .modal.fade .modal-dialog {
        transition: transform 0.3s ease-out;
        transform: translate(0, -50px);
    }
    .modal.show .modal-dialog {
        transform: translate(0, 0);
    }

    /* Styling form input di modal */
    #tambahObatModal .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }

    #editObatModal .form-control:focus {
        border-color: #f39c12;
        box-shadow: 0 0 0 0.2rem rgba(243, 156, 18, 0.15);
    }
</style>
@endpush

@push('scripts')
<script>
    // Buka modal jika ada error validasi
    @if($errors->any() && old('_token'))
        document.addEventListener('DOMContentLoaded', function() {
            const modalElement = document.getElementById('tambahObatModal');
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        });
    @endif

    // Reset form ketika modal ditutup (hanya jika tidak ada error)
    document.getElementById('tambahObatModal').addEventListener('hidden.bs.modal', function () {
        @if(!$errors->any())
            document.getElementById('formTambahObat').reset();
            // Hapus class invalid jika ada
            const invalidInputs = this.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => {
                input.classList.remove('is-invalid');
            });
            const invalidFeedbacks = this.querySelectorAll('.invalid-feedback');
            invalidFeedbacks.forEach(feedback => {
                feedback.remove();
            });
        @endif
    });

    // Handle form submission - tambahkan loading state
    document.getElementById('formTambahObat').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';
        
        // Jika form berhasil submit, tombol akan tetap disabled sampai redirect
        // Jika ada error, halaman akan reload dan modal akan terbuka lagi
    });

    // Handle Edit Modal - Isi form dengan data dari button
    const editObatModal = document.getElementById('editObatModal');
    editObatModal.addEventListener('show.bs.modal', function (event) {
        // Button yang memicu modal
        const button = event.relatedTarget;
        
        // Ambil data dari atribut data-*
        const obatId = button.getAttribute('data-obat-id');
        const obatNama = button.getAttribute('data-obat-nama');
        const obatKode = button.getAttribute('data-obat-kode');
        const obatSatuan = button.getAttribute('data-obat-satuan');
        const obatStok = button.getAttribute('data-obat-stok');
        const obatHargaBeli = button.getAttribute('data-obat-harga-beli');
        const obatHargaJual = button.getAttribute('data-obat-harga-jual');
        const obatExpiredDate = button.getAttribute('data-obat-expired-date');

        // Update form action URL
        const form = editObatModal.querySelector('#formEditObat');
        form.action = '{{ route("owner.obat.update", ":id") }}'.replace(':id', obatId);
        
        // Simpan ID di hidden input
        editObatModal.querySelector('#edit_obat_id').value = obatId;

        // Isi form dengan data
        editObatModal.querySelector('#edit_nama').value = obatNama || '';
        editObatModal.querySelector('#edit_kode').value = obatKode || '';
        editObatModal.querySelector('#edit_satuan').value = obatSatuan || '';
        editObatModal.querySelector('#edit_stok').value = obatStok || 0;
        editObatModal.querySelector('#edit_harga_beli').value = obatHargaBeli || '';
        editObatModal.querySelector('#edit_harga_jual').value = obatHargaJual || '';
        editObatModal.querySelector('#edit_expired_date').value = obatExpiredDate || '';
    });

    // Reset form edit ketika modal ditutup
    editObatModal.addEventListener('hidden.bs.modal', function () {
        @if(!$errors->any())
            // Hapus class invalid jika ada
            const invalidInputs = this.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => {
                input.classList.remove('is-invalid');
            });
            const invalidFeedbacks = this.querySelectorAll('.invalid-feedback');
            invalidFeedbacks.forEach(feedback => {
                feedback.remove();
            });
        @endif
    });

    // Handle form edit submission - tambahkan loading state
    document.getElementById('formEditObat').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Memperbarui...';
    });

    // Buka modal edit jika ada error validasi (untuk edit)
    // Cek apakah ada old('_method') yang bernilai 'PUT'
    @if($errors->any() && old('_method') == 'PUT')
        document.addEventListener('DOMContentLoaded', function() {
            const modalElement = document.getElementById('editObatModal');
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
            
            // Update form action dengan ID dari old('obat_id') jika ada
            const form = document.getElementById('formEditObat');
            @if(old('obat_id'))
                const obatId = {{ old('obat_id') }};
                form.action = '{{ route("owner.obat.update", ":id") }}'.replace(':id', obatId);
                document.getElementById('edit_obat_id').value = obatId;
            @endif
        });
    @endif
</script>
@endpush

