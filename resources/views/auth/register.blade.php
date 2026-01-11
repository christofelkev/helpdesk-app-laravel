@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg">
            <div class="card-header bg-success text-white text-center py-3">
                <h3 class="card-title fw-bold mb-0">Register</h3>
            </div>
            <div class="card-body p-5">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="name" class="form-label text-gray-700 fw-bold">Full Name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label text-gray-700 fw-bold">Email Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
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

                    <div class="mb-4">
                        <label for="password-confirm" class="form-label text-gray-700 fw-bold">Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg shadow-sm hover:translate-y-1 transition duration-150">
                            Register
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3 bg-light">
                <p class="mb-0">Already have an account? <a href="{{ route('login') }}" class="text-primary fw-bold">Login</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
