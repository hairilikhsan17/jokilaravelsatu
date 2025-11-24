@extends('layouts.owner')

@section('title', isset($staff) ? 'Edit Staff' : 'Tambah Staff')

@section('content')
<div class="card" style="border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0; border: none;">
        <h5 class="mb-0">
            <i class="bi bi-{{ isset($staff) ? 'pencil-square' : 'plus-circle' }} me-2"></i>
            {{ isset($staff) ? 'Edit Staff' : 'Tambah Staff' }}
        </h5>
    </div>
    <div class="card-body">
        @include('owner.staff.modal')
    </div>
</div>
@endsection

