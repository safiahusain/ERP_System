@extends('layouts.auth')

@section('content')
    <div class="auto-form-wrapper">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label class="label">Email</label>
                <div class="input-group">
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Email" value="{{ old('email') }}" required
                        autocomplete="email" autofocus>
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="label">Password</label>
                <div class="input-group">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="*********" name="password" required autocomplete="current-password">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-primary submit-btn btn-block">Login</button>
            </div>
            <div class="form-group d-flex justify-content-between">
                <div class="form-check form-check-flat mt-0">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" checked> Keep me signed in
                    </label>
                </div>
                @if (Route::has('password.request'))
                    {{-- <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a> --}}
                    <a href="{{ route('password.request') }}" class="text-small forgot-password text-black">{{ __('Forgot Your Password?') }}</a>
                @endif
            </div>
            <div class="text-block text-center my-3">
                <span class="text-small font-weight-semibold">Not a member ?</span>
                <a href="{{ route('register') }}" class="text-black text-small">Create new account</a>
            </div>
        </form>
    </div>
@endsection
