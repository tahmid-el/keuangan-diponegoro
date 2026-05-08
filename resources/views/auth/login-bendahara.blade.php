<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Bendahara - SRIKAN-Diponegoro</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Bootstrap CSS (from Vite or CDN, adding CDN as fallback for styling outside app) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #133e87;
            --secondary-color: #0e2d63;
            --accent-color: #4cc9f0;
            --text-main: #2b2d42;
            --text-muted: #8d99ae;
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Outfit', sans-serif;
            background-color: #f8f9fa;
        }

        /* Animated Mesh Gradient Background */
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at top left, #e2e8f0 0%, #cbd5e1 100%);
            position: relative;
            overflow: hidden;
            padding: 2rem;
        }

        /* Decorative Background Elements */
        .auth-wrapper::before, .auth-wrapper::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            animation: float 10s infinite ease-in-out alternate;
        }

        .auth-wrapper::before {
            width: 400px;
            height: 400px;
            background: rgba(19, 62, 135, 0.3); /* #133e87 with opacity */
            top: -100px;
            right: -100px;
        }

        .auth-wrapper::after {
            width: 500px;
            height: 500px;
            background: rgba(76, 201, 240, 0.3);
            bottom: -150px;
            left: -150px;
            animation-delay: -5s;
        }

        @keyframes float {
            0% { transform: translate(0, 0); }
            100% { transform: translate(30px, 30px); }
        }

        /* Glassmorphism Card */
        .login-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 480px;
            padding: 3rem;
            position: relative;
            z-index: 1;
            transform: translateY(20px);
            opacity: 0;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes slideUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .school-logo-container {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            padding: 10px;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        .login-card:hover .school-logo-container {
            transform: scale(1);
        }

        .school-logo-container img {
            max-width: 100%;
            height: auto;
        }

        .login-title {
            font-weight: 700;
            color: var(--text-main);
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
            font-weight: 400;
        }

        /* Custom Form Inputs */
        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-control {
            border: 2px solid #edf2f7;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            height: auto;
            font-size: 1rem;
            background-color: #f8fafc;
            color: var(--text-main);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(19, 62, 135, 0.1);
            background-color: #ffffff;
        }

        .form-floating > label {
            padding: 1rem 1.25rem;
            color: var(--text-muted);
        }

        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            transform: scale(0.85) translateY(-0.75rem) translateX(0.15rem);
            color: var(--primary-color);
            background-color: transparent;
        }

        .input-icon {
            position: absolute;
            right: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            transition: color 0.3s ease;
            z-index: 5;
        }

        .form-control:focus + .input-icon {
            color: var(--primary-color);
        }

        /* Custom Checkbox */
        .form-check-input {
            width: 1.2rem;
            height: 1.2rem;
            border-radius: 4px;
            border: 2px solid #cbd5e1;
            margin-top: 0.15rem;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            color: var(--text-main);
            font-size: 0.95rem;
            font-weight: 500;
        }

        /* Buttons */
        .btn-login {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1.1rem;
            font-weight: 600;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(19, 62, 135, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(19, 62, 135, 0.4);
            color: white;
        }

        .btn-login:active {
            transform: translateY(1px);
            box-shadow: 0 5px 10px rgba(19, 62, 135, 0.3);
        }

        .btn-login::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        .btn-login:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }

        @keyframes ripple {
            0% { transform: scale(0, 0); opacity: 0.5; }
            20% { transform: scale(25, 25); opacity: 0.5; }
            100% { opacity: 0; transform: scale(40, 40); }
        }

        .role-badge {
            display: inline-block;
            background: rgba(19, 62, 135, 0.1);
            color: var(--primary-color);
            padding: 0.35rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.2s;
        }

        .forgot-password:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .login-card {
                padding: 2rem;
                border-radius: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="auth-wrapper">
        <div class="login-card">
            
            <div class="login-header">
                <div class="school-logo-container">
                    <!-- Menggunakan logo sekolah yang sama dengan sidebar app -->
                    <img src="{{ asset('images/logo_sekolah.png') }}" alt="Logo Sekolah" onerror="this.src='https://ui-avatars.com/api/?name=MTs+D&background=133e87&color=fff&size=128'">
                </div>
                <div class="role-badge">
                    <i class="bi bi-shield-lock me-1"></i> Portal Bendahara
                </div>
                <h1 class="login-title">Selamat Datang Kembali</h1>
                <p class="login-subtitle">Masuk ke Sistem Rekapitulasi Informasi Keuangan MTs Diponegoro</p>
            </div>

            <!-- Form dummy karena belum ada Auth controller, action diarahkan ke dashboard -->
            <form action="/dashboard" method="GET">
                <!-- CSRF token will be needed later when it's POST -->
                <!-- @csrf -->

                <div class="form-floating position-relative">
                    <input type="email" class="form-control" id="emailInput" placeholder="name@example.com" required>
                    <label for="emailInput">Alamat Email atau NIP</label>
                    <i class="bi bi-person input-icon"></i>
                </div>

                <div class="form-floating position-relative">
                    <input type="password" class="form-control" id="passwordInput" placeholder="Password" required>
                    <label for="passwordInput">Kata Sandi</label>
                    <!-- Toggle password visibility button (optional) -->
                    <i class="bi bi-eye-slash input-icon" id="togglePassword" style="cursor: pointer;"></i>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">
                            Ingat Saya
                        </label>
                    </div>
                    <a href="#" class="forgot-password">Lupa Sandi?</a>
                </div>

                <button type="submit" class="btn btn-login">
                    Masuk Sekarang <i class="bi bi-arrow-right ms-2"></i>
                </button>
            </form>

            <div class="text-center mt-4">
                <p class="text-muted" style="font-size: 0.85rem;">
                    &copy; {{ date('Y') }} MTs Diponegoro Tegalsari. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <!-- Script for password toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('passwordInput');

            togglePassword.addEventListener('click', function (e) {
                // toggle the type attribute
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                // toggle the icon
                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
            });
        });
    </script>
</body>
</html>
