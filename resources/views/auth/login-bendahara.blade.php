<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SRIKAN Diponegoro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #133e87;
            --secondary-color: #0e2d63;
            --accent-color: #4cc9f0;
            --text-main: #2b2d42;
            --text-muted: #8d99ae;
        }
        body, html { height: 100%; margin: 0; font-family: 'Outfit', sans-serif; background-color: #f8f9fa; }
        .auth-wrapper {
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            background: radial-gradient(circle at top left, #e2e8f0 0%, #cbd5e1 100%);
            position: relative; overflow: hidden; padding: 2rem;
        }
        .auth-wrapper::before, .auth-wrapper::after {
            content: ''; position: absolute; border-radius: 50%; filter: blur(80px);
            z-index: 0; animation: float 10s infinite ease-in-out alternate;
        }
        .auth-wrapper::before { width: 400px; height: 400px; background: rgba(19,62,135,0.3); top: -100px; right: -100px; }
        .auth-wrapper::after  { width: 500px; height: 500px; background: rgba(76,201,240,0.3); bottom: -150px; left: -150px; animation-delay: -5s; }
        @keyframes float { 0% { transform: translate(0,0); } 100% { transform: translate(30px,30px); } }
        .login-card {
            background: rgba(255,255,255,0.85); backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.5); border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08); width: 100%; max-width: 480px;
            padding: 3rem; position: relative; z-index: 1;
            animation: slideUp 0.6s cubic-bezier(0.16,1,0.3,1) forwards;
        }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .login-header { text-align: center; margin-bottom: 2.5rem; }
        .school-logo-container {
            width: 80px; height: 80px; background: white; border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.5rem; box-shadow: 0 10px 20px rgba(0,0,0,0.05); padding: 10px;
        }
        .school-logo-container img { max-width: 100%; height: auto; }
        .login-title { font-weight: 700; color: var(--text-main); font-size: 1.75rem; margin-bottom: 0.5rem; }
        .login-subtitle { color: var(--text-muted); font-size: 0.95rem; }
        .form-floating { margin-bottom: 1.5rem; }
        .form-control {
            border: 2px solid #edf2f7; border-radius: 12px; padding: 1rem 1.25rem;
            height: auto; font-size: 1rem; background-color: #f8fafc; color: var(--text-main); transition: all 0.3s ease;
        }
        .form-control:focus { border-color: var(--primary-color); box-shadow: 0 0 0 4px rgba(19,62,135,0.1); background-color: #fff; }
        .form-floating > label { padding: 1rem 1.25rem; color: var(--text-muted); }
        .input-icon { position: absolute; right: 1.25rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); z-index: 5; }
        .btn-login {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white; border: none; border-radius: 12px; padding: 1rem;
            font-size: 1.1rem; font-weight: 600; width: 100%; margin-top: 1rem;
            transition: all 0.3s ease; box-shadow: 0 10px 20px rgba(19,62,135,0.3);
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 15px 25px rgba(19,62,135,0.4); color: white; }
        .role-badge {
            display: inline-block; background: rgba(19,62,135,0.1); color: var(--primary-color);
            padding: 0.35rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600;
            margin-bottom: 1rem; letter-spacing: 0.5px; text-transform: uppercase;
        }
        .alert-danger { border-radius: 12px; font-size: 0.9rem; }
        .is-invalid { border-color: #dc3545 !important; }
        .invalid-feedback { font-size: 0.85rem; }
    </style>
</head>
<body>
<div class="auth-wrapper">
    <div class="login-card">
        <div class="login-header">
            <div class="school-logo-container">
                <img src="{{ asset('images/logo_sekolah.png') }}" alt="Logo Sekolah"
                     onerror="this.src='https://ui-avatars.com/api/?name=MTs+D&background=133e87&color=fff&size=128'">
            </div>
            <div class="role-badge"><i class="bi bi-shield-lock me-1"></i> Portal Login</div>
            <h1 class="login-title">Selamat Datang</h1>
            <p class="login-subtitle">Sistem Rekapitulasi Informasi Keuangan<br>MTs Diponegoro Tegalsari</p>
        </div>

        {{-- Tampilkan pesan error login --}}
        @if (session('error'))
            <div class="alert alert-danger"><i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}</div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            {{-- Email --}}
            <div class="form-floating position-relative">
                <input type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       id="emailInput"
                       name="email"
                       placeholder="name@example.com"
                       value="{{ old('email') }}"
                       required autofocus>
                <label for="emailInput">Alamat Email</label>
                <i class="bi bi-person input-icon"></i>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-floating position-relative">
                <input type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       id="passwordInput"
                       name="password"
                       placeholder="Password"
                       required>
                <label for="passwordInput">Kata Sandi</label>
                <i class="bi bi-eye-slash input-icon" id="togglePassword" style="cursor:pointer;"></i>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Remember Me --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Ingat Saya</label>
                </div>
            </div>

            <button type="submit" class="btn btn-login">
                Masuk Sekarang <i class="bi bi-arrow-right ms-2"></i>
            </button>
        </form>

        <div class="text-center mt-4">
            <p class="text-muted" style="font-size:0.85rem;">
                &copy; {{ date('Y') }} MTs Diponegoro Tegalsari. All rights reserved.
            </p>
        </div>
    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const pwd = document.getElementById('passwordInput');
        const type = pwd.getAttribute('type') === 'password' ? 'text' : 'password';
        pwd.setAttribute('type', type);
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });
</script>
</body>
</html>
