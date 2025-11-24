@extends('layouts.owner')

@section('title', 'Profil Owner')

@section('content')
<style>
    .profile-photo-container {
        text-align: center;
        padding: 2rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px 15px 0 0;
        color: white;
    }
    
    .profile-photo-wrapper {
        position: relative;
        display: inline-block;
        margin-bottom: 1rem;
    }
    
    .profile-photo {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        background: rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: rgba(255, 255, 255, 0.8);
    }
    
    .profile-photo img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .photo-upload-btn, .photo-edit-btn, .photo-delete-btn {
        position: absolute;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        border: 3px solid white;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    
    .photo-upload-btn {
        bottom: 10px;
        right: 10px;
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
    }
    
    .photo-edit-btn, .photo-delete-btn {
        opacity: 0;
        visibility: hidden;
        transform: scale(0.8);
    }
    
    .profile-photo-wrapper:hover .photo-edit-btn,
    .profile-photo-wrapper:hover .photo-delete-btn {
        opacity: 1;
        visibility: visible;
        transform: scale(1);
    }
    
    .photo-edit-btn {
        bottom: 10px;
        right: 10px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .photo-delete-btn {
        bottom: 10px;
        right: 65px;
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    }
    
    .photo-upload-btn:hover, .photo-edit-btn:hover, .photo-delete-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }
    
    .photo-upload-btn i, .photo-edit-btn i, .photo-delete-btn i {
        font-size: 1.2rem;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(243, 156, 18, 0.3);
    }
</style>

<div class="row">
    <div class="col-md-8 mx-auto">
        <!-- Profile Photo Card -->
        <div class="card mb-4" style="border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: none;">
            <div class="profile-photo-container">
                <div class="profile-photo-wrapper">
                    <div class="profile-photo" id="profilePhotoPreview">
                        @if($user->photo)
                            <img src="{{ asset('storage/photos/' . $user->photo) }}" alt="{{ $user->name }}" id="photoImg">
                        @else
                            <i class="bi bi-person-circle"></i>
                        @endif
                    </div>
                    @if($user->photo)
                        <label for="photo" class="photo-edit-btn" title="Edit Foto Profil">
                            <i class="bi bi-pencil-fill"></i>
                        </label>
                        <button type="button" class="photo-delete-btn" onclick="deletePhoto()" title="Hapus Foto Profil">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    @else
                        <label for="photo" class="photo-upload-btn" title="Upload Foto Profil">
                            <i class="bi bi-camera-fill"></i>
                        </label>
                    @endif
                </div>
                <h4 class="mb-0">{{ $user->name }}</h4>
                <p class="mb-0 opacity-75">{{ ucfirst($user->role) }}</p>
            </div>
        </div>

        <!-- Profile Information Card -->
        <div class="card mb-4" style="border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: none;">
            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0; border: none; padding: 1.5rem;">
                <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Informasi Profil</h5>
            </div>
            <div class="card-body" style="padding: 2rem;">
                <form action="{{ route('owner.profil.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                    @csrf
                    @method('PUT')
                    
                    <input type="file" id="photo" name="photo" accept="image/*" style="display: none;">
                    
                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" id="name" name="name" value="{{ $user->name }}" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ $user->email }}" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Role</label>
                        <input type="text" class="form-control form-control-lg" value="{{ ucfirst($user->role) }}" disabled style="background-color: #f8f9fa;">
                    </div>
                    
                    <div class="d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="bi bi-check-circle me-2"></i>Update Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password Card -->
        <div class="card" style="border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: none;">
            <div class="card-header" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white; border-radius: 15px 15px 0 0; border: none; padding: 1.5rem;">
                <h5 class="mb-0"><i class="bi bi-key me-2"></i>Ubah Password</h5>
            </div>
            <div class="card-body" style="padding: 2rem;">
                <form action="{{ route('owner.profil.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="current_password" class="form-label fw-bold">Password Saat Ini <span class="text-danger">*</span></label>
                        <input type="password" class="form-control form-control-lg" id="current_password" name="current_password" required>
                        @error('current_password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label fw-bold">Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control form-control-lg" id="password" name="password" required>
                        <small class="text-muted">Minimal 8 karakter</small>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control form-control-lg" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    
                    <div class="d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-warning btn-lg px-4">
                            <i class="bi bi-key-fill me-2"></i>Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Preview photo and auto submit when photo is selected
    document.getElementById('photo').addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const preview = document.getElementById('profilePhotoPreview');
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview" id="photoImg">`;
            }
            
            reader.readAsDataURL(this.files[0]);
            
            // Auto submit form after preview
            setTimeout(() => {
                document.getElementById('profileForm').submit();
            }, 100);
        }
    });
    
    // Delete photo function
    function deletePhoto() {
        if (confirm('Yakin ingin menghapus foto profil?')) {
            fetch('{{ route("owner.profil.photo.delete") }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success || response.ok) {
                    location.reload();
                } else {
                    alert('Terjadi kesalahan saat menghapus foto.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                location.reload();
            });
        }
    }
</script>
@endpush
@endsection
