<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Apotek Stok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            min-height: 100vh;
            height: 100vh;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: moveBackground 20s linear infinite;
            z-index: 0;
        }

        @keyframes moveBackground {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        /* Floating Shapes */
        .floating-shape {
            position: absolute;
            opacity: 0.12;
            animation: float 15s ease-in-out infinite;
        }

        .shape-1 {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #56ab2f, #a8e063);
            border-radius: 50%;
            top: 8%;
            left: 12%;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 140px;
            height: 140px;
            background: linear-gradient(135deg, #0ba360, #3cba92);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            top: 65%;
            right: 10%;
            animation-delay: 2s;
        }

        .shape-3 {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            border-radius: 50%;
            bottom: 15%;
            left: 18%;
            animation-delay: 4s;
        }

        .shape-4 {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #f093fb, #f5576c);
            border-radius: 50%;
            top: 25%;
            right: 20%;
            animation-delay: 3s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(180deg); }
        }

        .container {
            position: relative;
            z-index: 1;
        }

        .register-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100vh;
            padding: 20px;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            width: 100%;
            max-width: 520px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            animation: slideUp 0.6s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-header {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            padding: 2.5rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        .register-header::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 0.8; }
        }

        .register-header .logo {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2.5rem;
            color: #fff;
            position: relative;
            z-index: 1;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: float-icon 3s ease-in-out infinite;
        }

        @keyframes float-icon {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .register-header h2 {
            color: #fff;
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .register-header p {
            color: rgba(255, 255, 255, 0.9);
            margin: 0.5rem 0 0;
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
        }

        .register-body {
            padding: 2.5rem;
            overflow-y: auto;
            overflow-x: hidden;
            flex: 1;
            min-height: 0;
        }

        .register-body::-webkit-scrollbar {
            width: 6px;
        }

        .register-body::-webkit-scrollbar-track {
            background: transparent;
        }

        .register-body::-webkit-scrollbar-thumb {
            background: rgba(17, 153, 142, 0.3);
            border-radius: 10px;
        }

        .register-body::-webkit-scrollbar-thumb:hover {
            background: rgba(17, 153, 142, 0.5);
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label i {
            color: #11998e;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group-custom .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #11998e;
            font-size: 1.1rem;
            z-index: 3;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .form-control, .form-select {
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
            width: 100%;
        }

        .form-control:focus, .form-select:focus {
            border-color: #11998e;
            box-shadow: 0 0 0 0.2rem rgba(17, 153, 142, 0.15);
            background: #fff;
            transform: translateY(-2px);
        }

        .form-control.is-invalid, .form-select.is-invalid {
            border-color: #e74c3c;
            padding-right: 3rem;
        }

        .input-group-custom:focus-within .input-icon {
            color: #38ef7d;
            transform: translateY(-50%) scale(1.1);
        }

        .invalid-feedback {
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .invalid-feedback::before {
            content: '\F623';
            font-family: 'bootstrap-icons';
        }

        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            animation: slideDown 0.4s ease;
            border-left: 4px solid #e74c3c;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-danger {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            color: #721c24;
        }

        .alert ul {
            list-style: none;
            padding-left: 0;
        }

        .alert ul li::before {
            content: '\F623';
            font-family: 'bootstrap-icons';
            margin-right: 0.5rem;
            color: #e74c3c;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            font-size: 1.1rem;
            z-index: 2;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: #11998e;
        }

        .role-selector {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .role-option {
            flex: 1;
            position: relative;
        }

        .role-option input[type="radio"] {
            display: none;
        }

        .role-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.25rem;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f8f9fa;
            text-align: center;
        }

        .role-label i {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            color: #999;
            transition: all 0.3s ease;
        }

        .role-label span {
            font-weight: 600;
            color: #666;
            font-size: 0.95rem;
        }

        .role-option input[type="radio"]:checked + .role-label {
            border-color: #11998e;
            background: linear-gradient(135deg, rgba(17, 153, 142, 0.1), rgba(56, 239, 125, 0.1));
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(17, 153, 142, 0.2);
        }

        .role-option input[type="radio"]:checked + .role-label i {
            color: #11998e;
            transform: scale(1.1);
        }

        .role-option input[type="radio"]:checked + .role-label span {
            color: #11998e;
        }

        .btn-register {
            width: 100%;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(17, 153, 142, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-register::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.5s, height 0.5s;
        }

        .btn-register:hover::before {
            width: 400px;
            height: 400px;
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(17, 153, 142, 0.4);
        }

        .btn-register:active {
            transform: translateY(-1px);
        }

        .btn-register span {
            position: relative;
            z-index: 1;
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e0e0e0;
        }

        .login-link p {
            color: #666;
            margin: 0;
            font-size: 0.95rem;
        }

        .login-link a {
            color: #11998e;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
            color: #38ef7d;
            text-decoration: underline;
        }

        .password-strength {
            height: 4px;
            background: #e0e0e0;
            border-radius: 10px;
            margin-top: 0.5rem;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 10px;
        }

        .strength-weak {
            background: linear-gradient(90deg, #e74c3c, #c0392b);
            width: 33%;
        }

        .strength-medium {
            background: linear-gradient(90deg, #f39c12, #e67e22);
            width: 66%;
        }

        .strength-strong {
            background: linear-gradient(90deg, #11998e, #38ef7d);
            width: 100%;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .register-wrapper {
                padding: 10px;
            }

            .register-card {
                border-radius: 20px;
                max-height: 95vh;
            }

            .register-header {
                padding: 2rem 1.5rem;
            }

            .register-header h2 {
                font-size: 1.5rem;
            }

            .register-body {
                padding: 2rem 1.5rem;
            }

            .role-selector {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Shapes -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>
    <div class="floating-shape shape-4"></div>

    <div class="container">
        <div class="register-wrapper">
            <div class="register-card">
                <!-- Header -->
                <div class="register-header">
                    <div class="logo">
                        <i class="bi bi-capsule"></i>
                    </div>
                    <h2>Daftar Akun</h2>
                    <p>Buat akun baru untuk mulai mengelola stok</p>
                </div>

                <!-- Body -->
                <div class="register-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf
                        
                        <!-- Name Input -->
                        <div class="input-group-custom">
                            <label for="name" class="form-label">
                                <i class="bi bi-person-fill"></i>
                                Nama Lengkap
                            </label>
                            <i class="input-icon bi bi-person-fill"></i>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Masukkan nama lengkap"
                                   required 
                                   autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Input -->
                        <div class="input-group-custom">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope-fill"></i>
                                Email
                            </label>
                            <i class="input-icon bi bi-envelope-fill"></i>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="contoh@email.com"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Role Selection -->
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-shield-check"></i>
                                Pilih Role
                            </label>
                            <div class="role-selector">
                                <div class="role-option">
                                    <input type="radio" 
                                           name="role" 
                                           id="role_owner" 
                                           value="owner" 
                                           {{ old('role') == 'owner' ? 'checked' : '' }}>
                                    <label for="role_owner" class="role-label">
                                        <i class="bi bi-person-badge"></i>
                                        <span>Owner</span>
                                    </label>
                                </div>
                                <div class="role-option">
                                    <input type="radio" 
                                           name="role" 
                                           id="role_staff" 
                                           value="staff" 
                                           {{ old('role') == 'staff' ? 'checked' : '' }}>
                                    <label for="role_staff" class="role-label">
                                        <i class="bi bi-people"></i>
                                        <span>Staff</span>
                                    </label>
                                </div>
                            </div>
                            @error('role')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="input-group-custom">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock-fill"></i>
                                Password
                            </label>
                            <i class="input-icon bi bi-lock-fill"></i>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Minimal 8 karakter"
                                   required>
                            <span class="password-toggle" onclick="togglePassword('password', 'toggleIcon1')">
                                <i class="bi bi-eye" id="toggleIcon1"></i>
                            </span>
                            <div class="password-strength">
                                <div class="password-strength-bar" id="strengthBar"></div>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Confirmation Input -->
                        <div class="input-group-custom">
                            <label for="password_confirmation" class="form-label">
                                <i class="bi bi-lock-fill"></i>
                                Konfirmasi Password
                            </label>
                            <i class="input-icon bi bi-lock-fill"></i>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Ulangi password"
                                   required>
                            <span class="password-toggle" onclick="togglePassword('password_confirmation', 'toggleIcon2')">
                                <i class="bi bi-eye" id="toggleIcon2"></i>
                            </span>
                        </div>

                        <!-- Register Button -->
                        <button type="submit" class="btn-register">
                            <span>
                                <i class="bi bi-person-plus me-2"></i>
                                Daftar Sekarang
                            </span>
                        </button>
                        
                        <!-- Login Link -->
                        <div class="login-link">
                            <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }

        // Password strength checker
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('strengthBar');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;

            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/\d/)) strength++;
            if (password.match(/[^a-zA-Z\d]/)) strength++;

            strengthBar.className = 'password-strength-bar';

            if (strength === 0) {
                strengthBar.style.width = '0%';
            } else if (strength <= 2) {
                strengthBar.classList.add('strength-weak');
            } else if (strength === 3) {
                strengthBar.classList.add('strength-medium');
            } else {
                strengthBar.classList.add('strength-strong');
            }
        });

        // Add floating animation to inputs on focus
        document.querySelectorAll('.form-control, .form-select').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });

        // Add ripple effect to button
        document.querySelector('.btn-register').addEventListener('click', function(e) {
            let ripple = document.createElement('span');
            ripple.style.position = 'absolute';
            ripple.style.width = '20px';
            ripple.style.height = '20px';
            ripple.style.background = 'rgba(255,255,255,0.5)';
            ripple.style.borderRadius = '50%';
            ripple.style.transform = 'scale(0)';
            ripple.style.animation = 'ripple 0.6s ease-out';
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });

        // Role selector animation
        document.querySelectorAll('.role-option input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.role-label').forEach(label => {
                    label.style.transform = 'scale(1)';
                });
                
                if (this.checked) {
                    const label = this.nextElementSibling;
                    label.style.transform = 'scale(1.02)';
                }
            });
        });
    </script>
</body>
</html>