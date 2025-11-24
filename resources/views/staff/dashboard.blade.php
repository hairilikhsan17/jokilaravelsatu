@extends('layouts.staff')

@section('title', 'Dashboard Staff')

@section('content')
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Total Transaksi Saya</h5>
                <h2 class="card-text">{{ \App\Models\Transaksi::where('user_id', auth()->id())->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Total Obat Tersedia</h5>
                <h2 class="card-text">{{ \App\Models\Obat::count() }}</h2>
            </div>
        </div>
    </div>
</div>
@endsection

