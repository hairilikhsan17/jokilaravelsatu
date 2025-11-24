@extends('layouts.staff')

@section('title', 'Laporan Stok')

@section('content')
<!-- Notifikasi -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-file-earmark-text me-2"></i>Laporan Stok</h1>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahLaporanModal">
            <i class="bi bi-plus-circle"></i> Buat Laporan
        </button>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#cetakLaporanModal">
            <i class="bi bi-printer"></i> Cetak Laporan
        </button>
    </div>
</div>

<div class="card" style="border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
    <div class="card-body">
        <style>
            .table td, .table th {
                vertical-align: middle !important;
            }
        </style>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center align-middle" style="width: 50px;">No</th>
                        <th class="align-middle">Nama Obat/Alkes</th>
                        <th class="text-center align-middle">Jumlah</th>
                        <th class="text-center align-middle">Tanggal</th>
                        <th class="align-middle">Keterangan</th>
                        <th class="text-center align-middle" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporanStok as $laporan)
                        <tr>
                            <td class="text-center align-middle">{{ $loop->iteration + ($laporanStok->currentPage() - 1) * $laporanStok->perPage() }}</td>
                            <td class="align-middle">
                                <strong>{{ $laporan->obatAlkes->nama ?? '-' }}</strong>
                                @if($laporan->obatAlkes && $laporan->obatAlkes->kategori)
                                    <br><small class="text-muted">{{ $laporan->obatAlkes->kategori }}</small>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge bg-info" style="font-size: 0.9rem; padding: 0.5rem 0.8rem;">{{ $laporan->jumlah }}</span>
                            </td>
                            <td class="text-center align-middle">{{ $laporan->tanggal->format('d/m/Y') }}</td>
                            <td class="align-middle">{{ $laporan->keterangan ?? '-' }}</td>
                            <td class="text-center align-middle">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button type="button" 
                                            class="btn btn-sm btn-warning" 
                                            onclick="editLaporan({{ $laporan->id }})"
                                            title="Edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="deleteLaporan({{ $laporan->id }})"
                                            title="Hapus">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem; color: #ccc;"></i>
                                <p class="mt-2 text-muted">Tidak ada data laporan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $laporanStok->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah Laporan -->
<div class="modal fade" id="tambahLaporanModal" tabindex="-1" aria-labelledby="tambahLaporanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; border-radius: 15px 15px 0 0; border: none; padding: 1.5rem 2rem;">
                <h5 class="modal-title" id="tambahLaporanModalLabel" style="font-weight: 600;">
                    <i class="bi bi-file-earmark-text me-2"></i>Buat Laporan Stok
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <form id="formTambahLaporan">
                    @csrf
                    <div class="mb-3">
                        <label for="id_obat" class="form-label">Obat/Alkes <span class="text-danger">*</span></label>
                        <select class="form-select" id="id_obat" name="id_obat" required>
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
                        <label for="jumlah" class="form-label">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" required>
                        <div class="invalid-feedback"></div>
                        <small class="text-muted">Masukkan jumlah yang dilaporkan (minimal 1)</small>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Masukkan keterangan (opsional)" maxlength="500"></textarea>
                        <small class="text-muted">Maksimal 500 karakter</small>
                    </div>
                    <div class="d-flex gap-2 justify-content-end mt-4 pt-3" style="border-top: 1px solid #e0e0e0;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('staff.laporan.edit')
@include('staff.laporan.delete')

<!-- Modal Cetak Laporan -->
<div class="modal fade" id="cetakLaporanModal" tabindex="-1" aria-labelledby="cetakLaporanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border-radius: 15px 15px 0 0; border: none; padding: 1.5rem 2rem;">
                <h5 class="modal-title" id="cetakLaporanModalLabel" style="font-weight: 600;">
                    <i class="bi bi-printer me-2"></i>Cetak Laporan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <form method="GET" action="{{ route('staff.laporan.cetak') }}" target="_blank">
                    <div class="mb-3">
                        <label for="cetak_tanggal_awal" class="form-label">Tanggal Awal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="cetak_tanggal_awal" name="tanggal_awal" value="{{ now()->startOfMonth()->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="cetak_tanggal_akhir" class="form-label">Tanggal Akhir <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="cetak_tanggal_akhir" name="tanggal_akhir" value="{{ now()->endOfMonth()->format('Y-m-d') }}" required>
                    </div>
                    <div class="d-flex gap-2 justify-content-end mt-4 pt-3" style="border-top: 1px solid #e0e0e0;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-printer"></i> Cetak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Handle Tambah Laporan
    document.getElementById('formTambahLaporan').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        // Reset validation
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        
        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';
        
        fetch('{{ route("staff.laporan.store") }}', {
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
                showNotification('success', data.message || 'Laporan stok berhasil dibuat.');
                const modal = bootstrap.Modal.getInstance(document.getElementById('tambahLaporanModal'));
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
    document.getElementById('tambahLaporanModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('formTambahLaporan').reset();
        document.getElementById('tanggal').value = '{{ date("Y-m-d") }}';
        document.getElementById('formTambahLaporan').querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    });

    // Function untuk menampilkan notifikasi
    function showNotification(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'bi-check-circle' : 'bi-exclamation-triangle';
        
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert ${alertClass} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            <i class="bi ${icon} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        // Insert di atas h1
        const content = document.querySelector('.d-flex.justify-content-between');
        if (content) {
            content.parentNode.insertBefore(alertDiv, content);
        }
        
        // Auto dismiss setelah 5 detik
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
</script>
@endpush
@endsection
