@extends('layouts.owner')

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
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#cetakLaporanModal">
        <i class="bi bi-printer"></i> Cetak Laporan
    </button>
</div>

<!-- Filter Card -->
<div class="card mb-4" style="border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
    <div class="card-body">
        <form method="GET" action="{{ route('owner.laporan.index') }}" id="filterForm">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                    <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-3">
                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                </div>
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
                <div class="col-md-3">
                    <label for="search" class="form-label">Cari Obat/Alkes</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Nama obat..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    <a href="{{ route('owner.laporan.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tabel Laporan -->
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
                        <th class="align-middle">Staff</th>
                        <th class="align-middle">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporanStok as $laporan)
                        <tr>
                            <td class="text-center align-middle">{{ $loop->iteration + ($laporanStok->currentPage() - 1) * $laporanStok->perPage() }}</td>
                            <td class="align-middle">
                                <strong>{{ $laporan->obatAlkes->nama ?? '-' }}</strong>
                                @if($laporan->obatAlkes)
                                    <br><small class="text-muted">{{ $laporan->obatAlkes->kategori ?? '-' }}</small>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge bg-info" style="font-size: 0.9rem; padding: 0.5rem 0.8rem;">{{ $laporan->jumlah }}</span>
                            </td>
                            <td class="text-center align-middle">{{ $laporan->tanggal->format('d/m/Y') }}</td>
                            <td class="align-middle">
                                @if($laporan->staff)
                                    <div>
                                        <strong>{{ $laporan->staff->name }}</strong>
                                        <br><small class="text-muted">{{ ucfirst($laporan->staff->role) }}</small>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="align-middle">{{ $laporan->keterangan ?? '-' }}</td>
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
                <form method="GET" action="{{ route('owner.laporan.cetak') }}" target="_blank">
                    <div class="mb-3">
                        <label for="cetak_tanggal_awal" class="form-label">Tanggal Awal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="cetak_tanggal_awal" name="tanggal_awal" value="{{ now()->startOfMonth()->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="cetak_tanggal_akhir" class="form-label">Tanggal Akhir <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="cetak_tanggal_akhir" name="tanggal_akhir" value="{{ now()->endOfMonth()->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="cetak_id_staff" class="form-label">Staff</label>
                        <select class="form-select" id="cetak_id_staff" name="id_staff">
                            <option value="">Semua Staff</option>
                            @foreach($staffList as $staff)
                                <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                            @endforeach
                        </select>
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
@endsection

@push('scripts')
<script>
    // Auto submit form filter saat tanggal berubah
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        // Form akan submit normal
    });
</script>
@endpush
