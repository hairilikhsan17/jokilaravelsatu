@extends('layouts.owner')

@section('title', 'Stok Keluar')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Catat Stok Keluar</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('owner.transaksi.keluar.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="obat_id" class="form-label">Pilih Obat <span class="text-danger">*</span></label>
                        <select class="form-select @error('obat_id') is-invalid @enderror" 
                                id="obat_id" name="obat_id" required>
                            <option value="">-- Pilih Obat --</option>
                            @foreach ($obats as $obat)
                                <option value="{{ $obat->id }}" {{ old('obat_id') == $obat->id ? 'selected' : '' }}>
                                    {{ $obat->nama }} ({{ $obat->kode }}) - Stok: {{ $obat->stok }}
                                </option>
                            @endforeach
                        </select>
                        @error('obat_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                               id="jumlah" name="jumlah" value="{{ old('jumlah') }}" min="1" required>
                        @error('jumlah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                  id="keterangan" name="keterangan" rows="3">{{ old('keterangan', 'Stok keluar') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-danger">Simpan</button>
                        <a href="{{ route('owner.transaksi.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


