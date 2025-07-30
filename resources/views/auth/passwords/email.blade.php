@extends('layouts.app')

@section('content')

<main class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <div class="card shadow-lg border-0 rounded-4" style="max-width: 420px; width: 100%;">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <h3 class="fw-bold mb-1">Forgot Password</h3>
                <p class="text-muted small mb-0">Enter your email to receive a reset link</p>
            </div>

            {{-- Hiển thị thông báo thành công --}}
            @if (session('status'))
            <div class="alert alert-success small">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Button --}}
                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 shadow-sm">
                    Send Reset Link
                </button>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="btn btn-link p-0 small">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</main>

{{-- Custom styles --}}
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