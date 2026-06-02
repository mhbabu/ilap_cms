<div class="d-flex align-items-center justify-content-center" style="min-height: 100vh; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
    <div class="d-flex" style="width: 100%; max-width: 960px; min-height: 560px; border-radius: 1.5rem; overflow: hidden; box-shadow: 0 25px 70px rgba(0,0,0,0.35);">

        {{-- Brand Section --}}
        <div class="d-none d-md-flex flex-column justify-content-center" style="flex: 0 0 45%; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: #fff; padding: 3.5rem 2.5rem; position: relative; overflow: hidden;">
            <div style="position: relative; z-index: 1;">
                <div class="mb-5">
                    <svg width="48" height="48" viewBox="0 0 48 48" class="mb-4">
                        <rect width="48" height="48" rx="12" fill="#ffffff" opacity="0.2"/>
                        <path d="M14 16h20v3H14zM14 22h20v3H14zM14 28h12v3H14z" fill="#ffffff"/>
                    </svg>
                    <h1 class="fw-extrabold mb-2" style="font-size: 1.75rem;">iLAP CMS</h1>
                    <p style="opacity: 0.85; font-size: 0.95rem;">Campus & Franchise Management System</p>
                </div>

                <div class="d-flex flex-column gap-4 mt-3">
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
        </div>

        {{-- Login Form --}}
        <div class="d-flex align-items-center justify-content-center flex-grow-1" style="background: #ffffff; padding: 2.5rem 2rem;">
            <div style="width: 100%; max-width: 360px;">
                <div class="text-center mb-4">
                    <svg width="40" height="40" viewBox="0 0 40 40" class="mx-auto mb-3">
                        <rect width="40" height="40" rx="10" fill="#3b82f6"/>
                        <path d="M12 14h16v2H12zM12 19h16v2H12zM12 24h10v2H12z" fill="#fff"/>
                    </svg>
                    <h2 class="fw-extrabold" style="font-size: 1.5rem; color: #0f172a;">Welcome back</h2>
                    <p style="color: #64748b; font-size: 0.875rem;">Sign in to your iLAP account</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger-custom mb-4 d-flex align-items-center gap-2">
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
</div>

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
