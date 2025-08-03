@extends('layouts.app')

@section('content')

<main class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <div class="card shadow-lg border-0 rounded-4" style="max-width: 420px; width: 100%;">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                {{-- Bỏ logo --}}
                <h3 class="mt-3 mb-1 fw-bold">Chào mừng trở lại</h3>
                <p class="text-muted small mb-0">Vui lòng đăng nhập vào tài khoản của bạn</p>

            </div>

            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Địa chỉ Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Mật khẩu</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" required autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Remember & Forgot --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label small" for="remember">Lưu đăng nhập</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="small text-decoration-none">Quên mật khẩu?</a>
                </div>

                {{-- Button --}}
                <button class="btn btn-primary w-100 py-2 rounded-pill shadow-sm" type="submit">
                    Đăng nhập
                </button>

                <div class="text-center mt-4">
                    <span class="text-secondary small">Bạn chưa có tài khoản?</span>
                    <a href="{{ route('register') }}" class="btn btn-link p-0 ms-1">Tạo tài khoản</a>
                </div>
            </form>
        </div>
    </div>
</main>

{{-- Custom styles for login --}}
<style>
.input-group-text {
    border-right: 0;
}

.input-group .form-control {
    border-left: 0;
}

.form-control:focus {
    box-shadow: none;
    border-color: #0d6efd;
}
</style>

@endsection