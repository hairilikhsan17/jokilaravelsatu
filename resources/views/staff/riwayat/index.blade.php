@extends('layouts.staff')

@section('title', 'Riwayat Aktivitas')

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
    <h1><i class="bi bi-clock-history me-2"></i>Riwayat Aktivitas</h1>
</div>

<!-- Filter Card -->
<div class="card mb-4" style="border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
    <div class="card-body">
        <form method="GET" action="{{ route('staff.riwayat.index') }}" id="filterForm">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                    <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-3">
                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-4">
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
                    <a href="{{ route('staff.riwayat.index') }}" class="btn btn-secondary btn-sm">
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
                        <th class="align-middle">Nama Obat/Alkes</th>
                        <th class="text-center align-middle">Jenis Aksi</th>
                        <th class="text-center align-middle">Tanggal Aksi</th>
                        <th class="align-middle">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayatAktivitas as $riwayat)
                        <tr>
                            <td class="text-center align-middle">{{ $loop->iteration + ($riwayatAktivitas->currentPage() - 1) * $riwayatAktivitas->perPage() }}</td>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
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
@endsection
