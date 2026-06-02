<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login • iLAP CMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .login-wrapper {
            display: flex;
            width: 100%;
            max-width: 960px;
            min-height: 560px;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.35);
            background: #ffffff;
        }

        .login-brand {
            flex: 0 0 45%;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3.5rem 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .login-brand::after {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.6;
        }

        .login-brand > * {
            position: relative;
            z-index: 1;
        }

        .login-form-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 2rem;
            background: #ffffff;
        }

        .login-form-card {
            width: 100%;
            max-width: 360px;
        }

        .login-form-card .form-control {
            padding: 0.75rem 1rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.625rem;
            font-size: 0.95rem;
            background: transparent;
            box-shadow: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .login-form-card .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .login-form-card .input-group-text {
            background: transparent;
            border: 1.5px solid #e2e8f0;
            border-right: none;
            border-radius: 0.625rem 0 0 0.625rem;
            color: #94a3b8;
            padding: 0.75rem 0.75rem;
        }

        .login-form-card .input-group .form-control {
            border-left: none;
            border-radius: 0 0.625rem 0.625rem 0;
        }

        .login-form-card .input-group:focus-within .input-group-text {
            border-color: #3b82f6;
        }

        .login-form-card .input-group:focus-within .form-control {
            border-color: #3b82f6;
            border-left: 1.5px solid #3b82f6;
        }

        .login-btn {
            width: 100%;
            padding: 0.8rem;
            background: #3b82f6;
            color: #ffffff;
            border: none;
            border-radius: 0.625rem;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.15s;
        }

        .login-btn:hover {
            background: #2563eb;
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.2);
        }

        .login-btn-ss {
            width: 100%;
            padding: 0.7rem 1.25rem;
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #e2e8f0;
            border-radius: 0.625rem;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.15s;
        }

        .login-btn-ss:hover {
            background: #e2e8f0;
        }

        .toggle-password {
            cursor: pointer;
            color: #94a3b8;
            border: none;
            background: transparent;
            transition: color 0.15s;
        }

        .toggle-password:hover {
            color: #475569;
        }

        .form-check-input:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        .alert-danger-custom {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            border-radius: 0.75rem;
            padding: 0.8rem 1rem;
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            .login-brand {
                display: none;
            }

            .login-wrapper {
                max-width: 440px;
            }

            body {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <div class="login-brand">
            <div class="mb-5">
                <svg width="48" height="48" viewBox="0 0 48 48" class="mb-4">
                    <rect width="48" height="48" rx="12" fill="#ffffff" opacity="0.2"/>
                    <path d="M14 16h20v3H14zM14 22h20v3H14zM14 28h12v3H14z" fill="#ffffff"/>
                </svg>
                <h1 class="fw-extrabold mb-2" style="font-size: 1.75rem;">iLAP CMS</h1>
                <p style="opacity: 0.85; font-size: 0.95rem;">Campus & Franchise Management System</p>
            </div>

            <div class="space-y-4 mt-3">
                <div class="d-flex align-items-start gap-3">
                    <div style="width: 2.5rem; height: 2.5rem; border-radius: 0.75rem; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-user-group"></i>
                    </div>
                    <div>
                        <div class="fw-semibold mb-1">Student Management</div>
                        <div style="opacity: 0.85; font-size: 0.875rem;">Complete enrollment, progress tracking & communications</div>
                    </div>
                </div>

                <div class="d-flex align-items-start gap-3">
                    <div style="width: 2.5rem; height: 2.5rem; border-radius: 0.75rem; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <div>
                        <div class="fw-semibold mb-1">Finance & Payments</div>
                        <div style="opacity: 0.85; font-size: 0.875rem;">Payment plans, invoices & financial reporting</div>
                    </div>
                </div>

                <div class="d-flex align-items-start gap-3">
                    <div style="width: 2.5rem; height: 2.5rem; border-radius: 0.75rem; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-file-shield"></i>
                    </div>
                    <div>
                        <div class="fw-semibold mb-1">Documents</div>
                        <div style="opacity: 0.85; font-size: 0.875rem;">Upload, verify & manage student documents</div>
                    </div>
                </div>
            </div>

            <div class="mt-auto pt-5" style="font-size: 0.75rem; opacity: 0.6;">
                &copy; {{ date('Y') }} iLAP CMS. All rights reserved.
            </div>
        </div>

        <div class="login-form-section">
            <div class="login-form-card">
                <div class="text-center mb-4">
                    <svg width="40" height="40" viewBox="0 0 40 40" class="mx-auto mb-3">
                        <rect width="40" height="40" rx="10" fill="#3b82f6"/>
                        <path d="M12 14h16v2H12zM12 19h16v2H12zM12 24h10v2H12z" fill="#fff"/>
                    </svg>
                    <h2 class="fw-extrabold" style="font-size: 1.5rem; color: #0f172a;">Welcome back</h2>
                    <p style="color: #64748b; font-size: 0.875rem;">Sign in to your iLAP account</p>
                </div>

                @if($errors->any())
                    <div class="alert-danger-custom mb-4 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span class="small fw-medium">{{ $errors->first('email') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="d-flex flex-column gap-3">
                    @csrf

                    <div>
                        <label class="form-label fw-semibold small mb-1" style="color:#374151;">
                            Email Address <span style="color:#dc2626;">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-regular fa-envelope"></i>
                            </span>
                            <input type="email" name="email" id="email" required autofocus autocomplete="email"
                                   placeholder="you@example.com" class="form-control"
                                   value="{{ old('email') }}">
                        </div>
                    </div>

                    <div>
                        <label class="form-label fw-semibold small mb-1" style="color:#374151;">
                            Password <span style="color:#dc2626;">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password" name="password" id="password" required autocomplete="current-password"
                                   placeholder="••••••••••••" class="form-control">
                            <button type="button" onclick="togglePwd(this)" class="toggle-password px-3">
                                <i class="fa-regular fa-eye" id="eye-icon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between pt-1">
                        <div class="form-check mb-0">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label small" for="remember" style="color:#475569;">
                                Remember me
                            </label>
                        </div>
                        <a href="#" class="small fw-medium text-decoration-none" style="color:#3b82f6;">
                            Forgot password?
                        </a>
                    </div>

                    <button type="submit" class="login-btn mt-1">
                        Sign In
                    </button>
                </form>

                <div class="text-center mt-4">
                    <span style="color: #94a3b8; font-size: 0.75rem;">or continue with</span>
                </div>

                <div class="mt-3">
                    <button type="button" class="login-btn-ss d-flex align-items-center justify-content-center gap-2">
                        <i class="fa-solid fa-globe"></i>
                        Single Sign-On
                    </button>
                </div>

                <div class="text-center mt-4 pt-3" style="border-top: 1px solid #f1f5f9;">
                    <p style="color: #64748b; font-size: 0.75rem;">
                        &copy; {{ date('Y') }} iLAP CMS. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePwd(btn) {
            const input = btn.closest('.input-group').querySelector('input[type="password"], input[type="text"]');
            const icon = btn.querySelector('#eye-icon, .fa-eye, .fa-eye-slash');
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            if (icon) {
                icon.classList.toggle('fa-eye-slash', !isPassword);
                icon.classList.toggle('fa-eye', isPassword);
            }
        }
    </script>
</body>
</html>
