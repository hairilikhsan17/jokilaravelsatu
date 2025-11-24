@extends('layouts.owner')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Daftar Transaksi</h1>
    <div>
        <a href="{{ route('owner.transaksi.masuk') }}" class="btn btn-success">
            <i class="bi bi-box-arrow-in-down"></i> Stok Masuk
        </a>
        <a href="{{ route('owner.transaksi.keluar') }}" class="btn btn-danger">
            <i class="bi bi-box-arrow-up"></i> Stok Keluar
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Obat</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>User</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $transaksi)
                        <tr>
                            <td>{{ $loop->iteration + ($transaksis->currentPage() - 1) * $transaksis->perPage() }}</td>
                            <td>{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $transaksi->obat->nama }} ({{ $transaksi->obat->kode }})</td>
                            <td>
                                @if($transaksi->jenis === 'masuk')
                                    <span class="badge bg-success">Masuk</span>
                                @else
                                    <span class="badge bg-danger">Keluar</span>
                                @endif
                            </td>
                            <td>{{ $transaksi->jumlah }}</td>
                            <td>{{ $transaksi->keterangan }}</td>
                            <td>{{ $transaksi->user->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $transaksis->links() }}
        </div>
    </div>
</div>
@endsection


