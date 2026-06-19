<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <title>Register - TravelTime</title>
        <meta name="description" content="" />

        <!-- Favicons -->
        <link href="{{ asset('frontend/img/favicon.png')}}" rel="icon" />
        <link href="{{ asset('frontend/img/apple-touch-icon.png')}}" rel="apple-touch-icon" />

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com" rel="preconnect" />
        <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Poppins:wght@300;400;500;600;700&family=Raleway:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

        <!-- Vendor CSS -->
        <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />
        <link href="{{ asset('frontend/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet" />

        <!-- Main CSS -->
        <link href="{{ asset('frontend/css/main.css')}}" rel="stylesheet" />

        <style>
            :root {
                --color-primary: #7c3aed;
                --color-secondary: #a855f7;
            }

            .auth-page {
                min-height: 100vh;
                display: flex;
                align-items: center;
                background: linear-gradient(
                        135deg,
                        rgba(76, 29, 149, 0.75),
                        rgba(124, 58, 237, 0.55)
                    ),
                    url('{{ asset('frontend/img/travel/destination-1.webp') }}')
                    center/cover no-repeat fixed;
                padding: 80px 0 40px;
            }

            .auth-card {
                background: #fff;
                border-radius: 16px;
                box-shadow: 0 20px 60px rgba(124, 58, 237, 0.25);
                overflow: hidden;
                max-width: 480px;
                width: 100%;
                margin: 0 auto;
            }

            .auth-card-header {
                background: linear-gradient(
                    135deg,
                    #7c3aed,
                    #a855f7
                );
                padding: 32px 40px 24px;
                text-align: center;
                color: #fff;
            }

            .auth-card-header .sitename {
                font-size: 1.8rem;
                font-weight: 700;
                letter-spacing: 1px;
            }

            .auth-card-header p {
                margin: 6px 0 0;
                opacity: 0.9;
                font-size: 0.9rem;
            }

            .auth-card-body {
                padding: 36px 40px 40px;
            }

            .auth-card-body .form-label {
                font-weight: 500;
                color: #444;
                font-size: 0.875rem;
            }

            .auth-card-body .form-control {
                border-radius: 8px;
                padding: 10px 14px;
                border: 1.5px solid #ddd6fe;
                font-size: 0.95rem;
                transition: all 0.3s ease;
            }

            .auth-card-body .form-control:focus {
                border-color: #7c3aed;
                box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.15);
            }

            .auth-card-body .input-group .form-control {
                border-right: 0;
            }

            .auth-card-body .input-group-text {
                background: #fff;
                border: 1.5px solid #ddd6fe;
                border-left: 0;
                border-radius: 0 8px 8px 0;
                cursor: pointer;
                color: #7c3aed;
            }

            .btn-auth {
                background: linear-gradient(
                    135deg,
                    #7c3aed,
                    #a855f7
                );
                color: #fff;
                border: none;
                border-radius: 8px;
                padding: 12px;
                font-weight: 600;
                font-size: 0.95rem;
                width: 100%;
                transition: all 0.3s ease;
            }

            .btn-auth:hover {
                background: linear-gradient(
                    135deg,
                    #6d28d9,
                    #9333ea
                );
                transform: translateY(-2px);
                color: #fff;
            }

            .password-strength {
                height: 4px;
                border-radius: 4px;
                background: #e9d5ff;
                margin-top: 6px;
                overflow: hidden;
            }

            .password-strength-bar {
                height: 100%;
                border-radius: 4px;
                transition: width 0.3s, background 0.3s;
                width: 0%;
            }

            .auth-link {
                color: #7c3aed;
                font-weight: 600;
                text-decoration: none;
            }

            .auth-link:hover {
                color: #5b21b6;
                text-decoration: underline;
            }

            .alert-danger {
                border-radius: 8px;
                font-size: 0.875rem;
                border-left: 4px solid #7c3aed;
            }
        </style>
    </head>

    <body>
        <!-- Navbar -->
        <header id="header" class="header d-flex align-items-center fixed-top">
            <div class="container position-relative d-flex align-items-center justify-content-between">
                <a href="{{ route('v1.frontend.dashboard') }}" class="logo d-flex align-items-center me-auto me-xl-0">
                    <h1 class="sitename">TravelTime</h1>
                </a>
                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="{{ route('v1.frontend.dashboard') }}">Home</a></li>
                        <li><a href="{{ route('v1.frontend.destination') }}">Destinations</a></li>
                        <li><a href="{{ route('v1.frontend.tours') }}">Tours</a></li>
                        <li><a href="{{ route('v1.frontend.hotel') }}">Hotels</a></li>
                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>
                <a class="btn-getstarted" href="{{ route('v1.frontend.login.login') }}">Login</a>
            </div>
        </header>

        <!-- Auth Section -->
        <div class="auth-page">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-7 col-xl-6">
                        <div class="auth-card">
                            <!-- Header -->
                            <div class="auth-card-header">
                                <div class="sitename">TravelTime</div>
                                <p>Create your account and start exploring the world</p>
                            </div>

                            <!-- Body -->
                            <div class="auth-card-body">

                                @if($errors->any())
                                <div class="alert alert-danger mb-4" role="alert">
                                    <ul class="mb-0 ps-3">
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <form action="{{ route('v1.frontend.login.register.process') }}" method="POST">
                                    @csrf

                                    <!-- Name -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input
                                            type="text"
                                            id="name"
                                            name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Your full name"
                                            value="{{ old('name') }}"
                                            required
                                            autofocus
                                        />
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input
                                            type="email"
                                            id="email"
                                            name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="your@email.com"
                                            value="{{ old('email') }}"
                                            required
                                        />
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Phone (optional) -->
                                    <div class="mb-3">
                                        <label for="hp" class="form-label">
                                            Phone Number
                                            <span class="text-muted fw-normal">(optional)</span>
                                        </label>
                                        <input
                                            type="text"
                                            id="hp"
                                            name="hp"
                                            class="form-control @error('hp') is-invalid @enderror"
                                            placeholder="+62 812 3456 7890"
                                            value="{{ old('hp') }}"
                                        />
                                        @error('hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group">
                                            <input
                                                type="password"
                                                id="password"
                                                name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Min. 8 characters"
                                                required
                                            />
                                            <span class="input-group-text" id="togglePassword">
                                                <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                            </span>
                                            @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="password-strength mt-1">
                                            <div class="password-strength-bar" id="strengthBar"></div>
                                        </div>
                                        <div id="strengthText" class="mt-1" style="font-size:0.75rem; color:#888;"></div>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="mb-4">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <div class="input-group">
                                            <input
                                                type="password"
                                                id="password_confirmation"
                                                name="password_confirmation"
                                                class="form-control"
                                                placeholder="Re-enter your password"
                                                required
                                            />
                                            <span class="input-group-text" id="toggleConfirm">
                                                <i class="bi bi-eye-slash" id="toggleConfirmIcon"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Terms -->
                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="terms" required />
                                            <label class="form-check-label text-muted" for="terms" style="font-size:0.875rem;">
                                                I agree to the
                                                <a href="#" class="auth-link">Terms of Service</a>
                                                and
                                                <a href="#" class="auth-link">Privacy Policy</a>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <button type="submit" class="btn-auth mb-4">
                                        <i class="bi bi-person-plus me-2"></i>Create Account
                                    </button>

                                    <!-- Login link -->
                                    <p class="text-center text-muted mb-0" style="font-size:0.9rem;">
                                        Already have an account?
                                        <a href="{{ route('v1.frontend.login.login') }}" class="auth-link">Sign in here</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vendor JS -->
        <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{ asset('frontend/js/main.js')}}"></script>

        <script>
            // Toggle password visibility
            document.getElementById('togglePassword').addEventListener('click', function () {
                const input = document.getElementById('password');
                const icon = document.getElementById('toggleIcon');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.className = 'bi bi-eye';
                } else {
                    input.type = 'password';
                    icon.className = 'bi bi-eye-slash';
                }
            });

            document.getElementById('toggleConfirm').addEventListener('click', function () {
                const input = document.getElementById('password_confirmation');
                const icon = document.getElementById('toggleConfirmIcon');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.className = 'bi bi-eye';
                } else {
                    input.type = 'password';
                    icon.className = 'bi bi-eye-slash';
                }
            });

            // Password strength indicator
            document.getElementById('password').addEventListener('input', function () {
                const val = this.value;
                const bar = document.getElementById('strengthBar');
                const text = document.getElementById('strengthText');
                let strength = 0;

                if (val.length >= 8) strength++;
                if (/[A-Z]/.test(val)) strength++;
                if (/[0-9]/.test(val)) strength++;
                if (/[^A-Za-z0-9]/.test(val)) strength++;

                const levels = [
                    { width: '0%', color: '#e0e0e0', label: '' },
                    { width: '25%', color: '#e53e3e', label: 'Weak' },
                    { width: '50%', color: '#dd6b20', label: 'Fair' },
                    { width: '75%', color: '#d69e2e', label: 'Good' },
                    { width: '100%', color: '#38a169', label: 'Strong' },
                ];

                const level = levels[strength];
                bar.style.width = level.width;
                bar.style.background = level.color;
                text.textContent = level.label ? `Password strength: ${level.label}` : '';
                text.style.color = level.color;
            });
        </script>
    </body>
</html>