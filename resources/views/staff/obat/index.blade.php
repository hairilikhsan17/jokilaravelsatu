@extends('layouts.staff')

@section('title', 'Data Obat / Alkes')

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
    <h1><i class="bi bi-capsule-pill me-2"></i>Data Obat / Alkes</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahObatModal">
        <i class="bi bi-plus-circle"></i> Tambah Data
    </button>
</div>

<div class="card" style="border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
    <div class="card-body">
        <style>
            .table td, .table th {
                vertical-align: middle !important;
            }
        </style>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center align-middle" style="width: 50px;">No</th>
                        <th class="align-middle">Nama</th>
                        <th class="text-center align-middle">Kategori</th>
                        <th class="text-center align-middle">Stok</th>
                        <th class="text-center align-middle">Satuan</th>
                        <th class="text-center align-middle">Kadaluarsa</th>
                        <th class="align-middle">Supplier</th>
                        <th class="text-center align-middle">Lokasi</th>
                        <th class="align-middle">Keterangan</th>
                        <th class="text-center align-middle" style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($obatAlkes as $obat)
                        <tr style="vertical-align: middle;">
                            <td class="text-center align-middle">{{ $loop->iteration + ($obatAlkes->currentPage() - 1) * $obatAlkes->perPage() }}</td>
                            <td class="align-middle">
                                <strong>{{ $obat->nama }}</strong>
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge bg-info">{{ $obat->kategori }}</span>
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge {{ $obat->stok < 10 ? 'bg-danger' : 'bg-success' }}">
                                    {{ $obat->stok }}
                                </span>
                            </td>
                            <td class="text-center align-middle">{{ $obat->satuan ?? '-' }}</td>
                            <td class="text-center align-middle">
                                @if($obat->kadaluarsa)
                                    @php
                                        $isExpired = $obat->kadaluarsa < now();
                                        $isNearExpired = $obat->kadaluarsa <= now()->addDays(30);
                                    @endphp
                                    <span class="badge {{ $isExpired ? 'bg-danger' : ($isNearExpired ? 'bg-warning' : 'bg-secondary') }}">
                                        {{ $obat->kadaluarsa->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="align-middle">{{ $obat->supplier ?? '-' }}</td>
                            <td class="text-center align-middle">
                                @if($obat->lokasi)
                                    <span class="badge bg-secondary">{{ $obat->lokasi }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($obat->keterangan)
                                    <small class="text-muted">{{ Str::limit($obat->keterangan, 50) }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button type="button" 
                                            class="btn btn-sm btn-warning" 
                                            onclick="editObat({{ $obat->id }})"
                                            title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="deleteObat({{ $obat->id }})"
                                            title="Hapus">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $obatAlkes->links() }}
        </div>
    </div>
</div>

@include('staff.obat.create')
@include('staff.obat.edit')
@include('staff.obat.delete')
@endsection

@push('scripts')
<script>
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

    // Handle Tambah Obat
    document.getElementById('formTambahObat').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        // Reset validation
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';
        
        fetch('{{ route("staff.obat.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
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
                showNotification('success', data.message || 'Data berhasil ditambahkan.');
                const modal = bootstrap.Modal.getInstance(document.getElementById('tambahObatModal'));
                modal.hide();
                setTimeout(() => {
                    window.location.reload();
                }, 300);
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
            showNotification('error', 'Terjadi kesalahan saat menyimpan data');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });

    // Handle Edit Obat
    function editObat(id) {
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
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_nama').value = data.nama || '';
            document.getElementById('edit_kategori').value = data.kategori || '';
            document.getElementById('edit_stok').value = data.stok || 0;
            // Format tanggal untuk input date (YYYY-MM-DD)
            if (data.kadaluarsa) {
                const tanggal = new Date(data.kadaluarsa);
                document.getElementById('edit_kadaluarsa').value = tanggal.toISOString().split('T')[0];
            } else {
                document.getElementById('edit_kadaluarsa').value = '';
            }
            document.getElementById('edit_supplier').value = data.supplier || '';
            document.getElementById('edit_satuan').value = data.satuan || '';
            document.getElementById('edit_lokasi').value = data.lokasi || '';
            document.getElementById('edit_keterangan').value = data.keterangan || '';
            
            const modal = new bootstrap.Modal(document.getElementById('editObatModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan saat mengambil data: ' + error.message);
        });
    }

    // Handle Update Obat
    document.getElementById('formEditObat').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const id = document.getElementById('edit_id').value;
        const formData = new FormData(form);
        formData.append('_method', 'PUT');
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        // Reset validation
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Memperbarui...';
        
        fetch(`{{ route("staff.obat.update", ":id") }}`.replace(':id', id), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
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
                showNotification('success', data.message || 'Data berhasil diperbarui.');
                const modal = bootstrap.Modal.getInstance(document.getElementById('editObatModal'));
                modal.hide();
                // Reload halaman setelah modal ditutup
                setTimeout(() => {
                    window.location.reload();
                }, 300);
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
            showNotification('error', 'Terjadi kesalahan saat memperbarui data: ' + error.message);
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });

    // Reset form ketika modal ditutup
    document.getElementById('tambahObatModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('formTambahObat').reset();
        document.getElementById('formTambahObat').querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    });

    document.getElementById('editObatModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('formEditObat').reset();
        document.getElementById('formEditObat').querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    });
</script>
@endpush

