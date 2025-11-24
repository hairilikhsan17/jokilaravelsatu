@extends('layouts.owner')

@section('title', 'Dashboard Owner')

@section('content')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Obat</h5>
                <h2 class="card-text">{{ \App\Models\Obat::count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Total Stok</h5>
                <h2 class="card-text">{{ \App\Models\Obat::sum('stok') }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Total Transaksi</h5>
                <h2 class="card-text">{{ \App\Models\Transaksi::count() }}</h2>
            </div>
        </div>
    </div>
</div>
@endsection

