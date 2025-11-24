@extends('layouts.owner')

@section('title', 'Manajemen Staff dan Owner')

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
    <h1><i class="bi bi-people me-2"></i>Manajemen Staff dan Owner</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahStaffModal">
        <i class="bi bi-plus-circle"></i> Tambah Staff
    </button>
</div>

<div class="card" style="border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
    <div class="card-body">
        <style>
            .table td, .table th {
                vertical-align: middle !important;
            }
            .badge-status {
                font-size: 0.85rem;
                padding: 0.4rem 0.8rem;
            }
            .btn-sm {
                width: 35px;
                height: 35px;
                padding: 0;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 8px;
                transition: all 0.3s ease;
            }
            .btn-sm:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            }
            .btn-sm i {
                font-size: 1rem;
            }
        </style>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center align-middle" style="width: 50px;">No</th>
                        <th class="align-middle">Nama</th>
                        <th class="align-middle">Email</th>
                        <th class="align-middle">Password</th>
                        <th class="text-center align-middle">Role</th>
                        <th class="text-center align-middle">Status Aktif</th>
                        <th class="text-center align-middle" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($staff as $s)
                        <tr style="vertical-align: middle;">
                            <td class="text-center align-middle">{{ $loop->iteration + ($staff->currentPage() - 1) * $staff->perPage() }}</td>
                            <td class="align-middle">{{ $s->name }}</td>
                            <td class="align-middle">{{ $s->email }}</td>
                            <td class="align-middle">
                                <code style="font-size: 0.85rem; color: #6c757d;">{{ substr($s->password, 0, 20) }}...</code>
                            </td>
                            <td class="text-center align-middle">
                                @if($s->role === 'owner')
                                    <span class="badge bg-danger badge-status">Owner</span>
                                @elseif($s->role === 'admin')
                                    <span class="badge bg-warning badge-status">Admin</span>
                                @else
                                    <span class="badge bg-info badge-status">Staff</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                @if($s->is_active)
                                    <span class="badge bg-success badge-status">Aktif</span>
                                @else
                                    <span class="badge bg-secondary badge-status">Non-Aktif</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <div class="d-flex gap-2 justify-content-center">
                                    <button type="button" 
                                            class="btn btn-sm btn-warning" 
                                            onclick="editStaff({{ $s->id }})"
                                            title="Edit Staff"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" 
                                            class="btn btn-sm btn-info" 
                                            onclick="ubahPasswordStaff({{ $s->id }})"
                                            title="Ubah Password"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top">
                                        <i class="bi bi-key"></i>
                                    </button>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="deleteStaff({{ $s->id }})"
                                            title="Hapus Staff"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            @if($s->role === 'owner' && $s->id === auth()->id()) disabled @endif>
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem; color: #ccc;"></i>
                                <p class="mt-2 text-muted">Tidak ada data staff</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $staff->links() }}
        </div>
    </div>
</div>

@include('owner.staff.modal')
@include('owner.staff.password')
@include('owner.staff.delete')
@endsection

@push('scripts')
<script>
    function editStaff(id) {
        fetch(`{{ route("owner.staff.edit", ":id") }}`.replace(':id', id), {
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
            document.getElementById('edit_staff_id').value = data.id;
            document.getElementById('edit_staff_name').value = data.name || '';
            document.getElementById('edit_staff_email').value = data.email || '';
            document.getElementById('edit_staff_role').value = data.role || 'staff';
            document.getElementById('edit_staff_is_active').value = (data.is_active == 1 || data.is_active === true) ? '1' : '0';
            
            const modal = new bootstrap.Modal(document.getElementById('editStaffModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengambil data: ' + error.message);
        });
    }

    function ubahPasswordStaff(id) {
        fetch(`{{ route("owner.staff.edit", ":id") }}`.replace(':id', id), {
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
            document.getElementById('password_staff_id').value = data.id;
            document.getElementById('password_staff_name').textContent = data.name || '-';
            document.getElementById('password_staff_email').textContent = data.email || '-';
            
            const modal = new bootstrap.Modal(document.getElementById('ubahPasswordStaffModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengambil data: ' + error.message);
        });
    }

    function deleteStaff(id) {
        fetch(`{{ route("owner.staff.edit", ":id") }}`.replace(':id', id), {
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
            document.getElementById('delete_staff_id').value = data.id;
            document.getElementById('delete_staff_name').textContent = data.name || '-';
            document.getElementById('delete_staff_email').textContent = data.email || '-';
            
            const modal = new bootstrap.Modal(document.getElementById('deleteStaffModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengambil data: ' + error.message);
        });
    }

    // Reset form ketika modal ditutup
    document.getElementById('tambahStaffModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('formTambahStaff').reset();
        document.getElementById('staff_is_active').checked = true;
    });

    document.getElementById('editStaffModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('formEditStaff').reset();
    });

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

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
