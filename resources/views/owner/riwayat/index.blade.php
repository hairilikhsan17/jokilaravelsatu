@extends('layouts.owner')

@section('title', 'Riwayat Aktivitas Staff')

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
    <h1><i class="bi bi-clock-history me-2"></i>Riwayat Aktivitas Staff</h1>
</div>

<!-- Filter Card -->
<div class="card mb-4" style="border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
    <div class="card-body">
        <form method="GET" action="{{ route('owner.riwayat.index') }}" id="filterForm">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="id_staff" class="form-label">Staff</label>
                    <select class="form-select" id="id_staff" name="id_staff">
                        <option value="">Semua Staff</option>
                        @foreach($staffList as $staff)
                            <option value="{{ $staff->id }}" {{ request('id_staff') == $staff->id ? 'selected' : '' }}>
                                {{ $staff->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                    <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-2">
                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-3">
                    <label for="jenis_aksi" class="form-label">Jenis Aksi</label>
                    <select class="form-select" id="jenis_aksi" name="jenis_aksi">
                        <option value="">Semua Aksi</option>
                        <option value="tambah" {{ request('jenis_aksi') == 'tambah' ? 'selected' : '' }}>Tambah</option>
                        <option value="update" {{ request('jenis_aksi') == 'update' ? 'selected' : '' }}>Edit</option>
                        <option value="hapus" {{ request('jenis_aksi') == 'hapus' ? 'selected' : '' }}>Hapus</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Filter
                    </button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <a href="{{ route('owner.riwayat.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tabel Riwayat Aktivitas -->
<div class="card" style="border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
    <div class="card-body">
        <style>
            .table td, .table th {
                vertical-align: middle !important;
            }
            .badge-aksi {
                font-size: 0.85rem;
                padding: 0.4rem 0.8rem;
            }
        </style>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center align-middle" style="width: 50px;">No</th>
                        <th class="align-middle">Nama Staff</th>
                        <th class="align-middle">Nama Obat/Alkes</th>
                        <th class="text-center align-middle">Jenis Aksi</th>
                        <th class="text-center align-middle">Tanggal Aksi</th>
                        <th class="align-middle">Keterangan</th>
                        <th class="text-center align-middle" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayatAktivitas as $riwayat)
                        <tr>
                            <td class="text-center align-middle">{{ $loop->iteration + ($riwayatAktivitas->currentPage() - 1) * $riwayatAktivitas->perPage() }}</td>
                            <td class="align-middle">
                                <strong>{{ $riwayat->staff->name ?? '-' }}</strong>
                                @if($riwayat->staff)
                                    <br><small class="text-muted">{{ ucfirst($riwayat->staff->role) }}</small>
                                @endif
                            </td>
                            <td class="align-middle">
                                <strong>{{ $riwayat->obatAlkes->nama ?? '-' }}</strong>
                                @if($riwayat->obatAlkes && $riwayat->obatAlkes->kategori)
                                    <br><small class="text-muted">{{ $riwayat->obatAlkes->kategori }}</small>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                @if($riwayat->jenis_aksi === 'tambah')
                                    <span class="badge bg-success badge-aksi">
                                        <i class="bi bi-plus-circle"></i> Tambah
                                    </span>
                                @elseif($riwayat->jenis_aksi === 'update')
                                    <span class="badge bg-warning badge-aksi">
                                        <i class="bi bi-pencil"></i> Edit
                                    </span>
                                @else
                                    <span class="badge bg-danger badge-aksi">
                                        <i class="bi bi-trash"></i> Hapus
                                    </span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <div>{{ $riwayat->tanggal->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $riwayat->tanggal->format('H:i:s') }}</small>
                            </td>
                            <td class="align-middle">{{ $riwayat->keterangan ?? '-' }}</td>
                            <td class="text-center align-middle">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button type="button" 
                                            class="btn btn-sm btn-warning" 
                                            onclick="editRiwayat({{ $riwayat->id }})"
                                            title="Edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="deleteRiwayat({{ $riwayat->id }})"
                                            title="Hapus">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem; color: #ccc;"></i>
                                <p class="mt-2 text-muted">Tidak ada riwayat aktivitas</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $riwayatAktivitas->links() }}
        </div>
    </div>
</div>

@include('owner.riwayat.edit')
@include('owner.riwayat.delete')
@endsection

@push('scripts')
<script>
    function editRiwayat(id) {
        fetch(`{{ route("owner.riwayat.edit", ":id") }}`.replace(':id', id), {
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
            document.getElementById('edit_riwayat_id').value = data.id;
            document.getElementById('edit_id_staff').value = data.id_staff;
            document.getElementById('edit_id_obat').value = data.id_obat;
            document.getElementById('edit_jenis_aksi').value = data.jenis_aksi;
            // Format tanggal untuk input date (YYYY-MM-DD)
            const tanggal = new Date(data.tanggal);
            document.getElementById('edit_tanggal').value = tanggal.toISOString().split('T')[0];
            // Format waktu untuk input time (HH:mm)
            const waktu = tanggal.toTimeString().slice(0, 5);
            document.getElementById('edit_waktu').value = waktu;
            document.getElementById('edit_keterangan').value = data.keterangan || '';
            
            const modal = new bootstrap.Modal(document.getElementById('editRiwayatModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan saat mengambil data: ' + error.message);
        });
    }

    function deleteRiwayat(id) {
        fetch(`{{ route("owner.riwayat.edit", ":id") }}`.replace(':id', id), {
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
            document.getElementById('delete_riwayat_id').value = data.id;
            document.getElementById('delete_riwayat_staff').textContent = data.staff ? data.staff.name : '-';
            document.getElementById('delete_riwayat_obat').textContent = data.obat_alkes ? data.obat_alkes.nama : (data.obatAlkes ? data.obatAlkes.nama : '-');
            document.getElementById('delete_riwayat_aksi').textContent = data.jenis_aksi === 'tambah' ? 'Tambah' : (data.jenis_aksi === 'update' ? 'Edit' : 'Hapus');
            document.getElementById('delete_riwayat_tanggal').textContent = new Date(data.tanggal).toLocaleDateString('id-ID') + ' ' + new Date(data.tanggal).toLocaleTimeString('id-ID');
            
            const modal = new bootstrap.Modal(document.getElementById('deleteRiwayatModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan saat mengambil data: ' + error.message);
        });
    }

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

