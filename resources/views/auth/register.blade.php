@extends('layouts.app')

@section('content')

<main class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <div class="card shadow-lg border-0 rounded-4" style="max-width: 400px; width: 100%;">
        <div class="card-body p-4">
            <div class="text-center mb-3">
                <h4 class="fw-bold mb-1">Đăng ký</h4>
                <p class="text-muted small mb-0">Tạo tài khoản mới</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <div class="mb-2">
                    <label for="name" class="form-label small mb-1">Họ và tên</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><i class="bi bi-person"></i></span>
                        <input type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div class="mb-2">
                    <label for="email" class="form-label small mb-1">Email</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                        <input type="email" id="email" name="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                            required>
                        @error('email')
                        <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Password --}}
                <div class="mb-2">
                    <label for="password" class="form-label small mb-1">Mật khẩu</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                        <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div class="mb-3">
                    <label for="password-confirm" class="form-label small mb-1">Xác nhận mật khẩu</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" id="password-confirm" name="password_confirmation" class="form-control"
                            required>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark w-100 rounded-pill py-2">
                    Đăng ký
                </button>

                <div class="text-center mt-3 small">
                    Bạn đã có tài khoản?
                    <a href="{{ route('login') }}" class="fw-semibold">Đăng nhập</a>
                </div>
            </form>
        </div>
    </div>
</main>

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