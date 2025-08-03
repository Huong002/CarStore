@extends('layouts.app')

@section('content')
<main class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <div class="card shadow-lg border-0 rounded-4" style="max-width: 400px; width: 100%;">
        <div class="card-body p-4">
            <div class="text-center mb-3">
                <h4 class="fw-bold mb-1">Đặt lại mật khẩu</h4>
                <p class="text-muted small mb-0">Nhập mật khẩu mới của bạn</p>
            </div>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label small mb-1">Email</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ $email ?? old('email') }}" required autofocus>
                        @error('email')
                        <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- New Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label small mb-1">Mật khẩu mới</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required>
                        @error('password')
                        <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div class="mb-4">
                    <label for="password-confirm" class="form-label small mb-1">Xác nhận mật khẩu</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><i class="bi bi-lock-fill"></i></span>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 shadow-sm">
                    Đặt lại mật khẩu
                </button>

                <div class="text-center mt-3 small">
                    <a href="{{ route('login') }}" class="fw-semibold">Quay lại đăng nhập</a>
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