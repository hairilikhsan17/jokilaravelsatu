@extends('layouts.owner')

@section('title', 'Dashboard Owner')

@section('content')
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2 text-white-50">Total Obat/Alkes</h6>
                        <h2 class="card-title mb-0">{{ $totalObat }}</h2>
                    </div>
                    <i class="bi bi-capsule-pill" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2 text-white-50">Total Stok</h6>
                        <h2 class="card-title mb-0">{{ number_format($totalStok) }}</h2>
                    </div>
                    <i class="bi bi-box-seam" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2 text-white-50">Stok Menipis</h6>
                        <h2 class="card-title mb-0">{{ $stokMenipis }}</h2>
                    </div>
                    <i class="bi bi-exclamation-triangle" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2 text-white-50">Laporan Baru</h6>
                        <h2 class="card-title mb-0">{{ $laporanBaru }}</h2>
                    </div>
                    <i class="bi bi-file-earmark-text" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

@if($stokMenipis > 0)
<div class="alert alert-warning alert-dismissible fade show" role="alert" style="border-radius: 15px; border-left: 5px solid #f39c12;">
    <i class="bi bi-exclamation-triangle me-2"></i>
    <strong>Peringatan!</strong> Ada {{ $stokMenipis }} item dengan stok menipis (< 10). 
    <a href="{{ route('owner.obat.index') }}" class="alert-link">Lihat Detail</a>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card" style="border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0; border: none;">
        <h5 class="mb-0"><i class="bi bi-speedometer2 me-2"></i>Ringkasan Dashboard</h5>
    </div>
    <div class="card-body">
        <p class="text-muted">Selamat datang di Dashboard Owner. Gunakan menu di sidebar untuk mengakses fitur-fitur aplikasi.</p>
    </div>
</div>
@endsection
