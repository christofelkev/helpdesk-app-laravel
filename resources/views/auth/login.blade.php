@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg">
            <div class="card-header bg-primary text-white text-center py-3">
                <h3 class="card-title fw-bold mb-0">Login</h3>
            </div>
            <div class="card-body p-5">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="email" class="form-label text-gray-700 fw-bold">Email Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label text-gray-700 fw-bold">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-4 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg shadow-sm hover:translate-y-1 transition duration-150">
                            Login
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3 bg-light">
                <p class="mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-primary fw-bold">Register</a></p>
                <div class="mt-2 text-sm text-gray-500">
                    <p>Demo Accounts:</p>
                    <p>Admin: admin@example.com / password</p>
                    <p>Staff: staff@example.com / password</p>
                    <p>Client: client@example.com / password</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
