@extends('layouts.auth')

@section('content')
<style>
    .login-card {
        background: rgba(255, 255, 255, 0.95);
        padding: 40px;
        border-radius: 15px;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        backdrop-filter: blur(10px);
    }

    .form-title {
        text-align: center;
        font-weight: 700;
        margin-bottom: 25px;
        font-size: 24px;
    }

    .form-control {
        border-radius: 10px;
        height: 45px;
        padding-right: 45px;
    }

    .form-control:focus {
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.3);
        border-color: #2563eb;
    }

    .input-group {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #ced4da;
        transition: 0.2s;
    }

    /* 👇 Focus poore group par */
    .input-group:focus-within {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
    }

    /* input */
    .input-group .form-control {
        border: none !important;
        box-shadow: none !important;
        border-radius: 0 !important;
    }

    /* icon button */
    .password-toggle {
        background: #e7f1ff;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 14px;
        cursor: pointer;
    }

    /* icon inside */
    .password-toggle i {
        font-size: 18px;
    }
    .submit-btn {
        background: linear-gradient(135deg, #2563eb, #1e40af);
        border: none;
        border-radius: 10px;
        height: 45px;
        font-weight: 600;
        transition: 0.3s;
    }

    .submit-btn:hover {
        opacity: 0.9;
    }

    .extra-links {
        font-size: 14px;
    }

    .extra-links a {
        color: #2563eb;
        text-decoration: none;
        font-weight: 500;
    }

    .extra-links a:hover {
        text-decoration: underline;
    }
</style>

<div class="login-card">
    <form method="POST" action="{{ url('/login') }}">
        @csrf

        <h3 class="form-title">Welcome Back 👋</h3>

        <!-- Email -->
        <div class="form-group mb-3">
            <label>Email Address</label>
            <div class="input-group">
                <input type="email" name="email" class="form-control"
                       placeholder="Enter your email" required>
            </div>
        </div>

        <!-- Password -->
        <div class="form-group mb-3">
            <label>Password</label>
            <div class="input-group">
                <input type="password" id="password" name="password"
                       class="form-control" placeholder="Enter your password" required>

                <button type="button" class="password-toggle" onclick="togglePassword()">
                    <i class="mdi mdi-eye-off" id="toggleIcon"></i>
                </button>

            </div>
        </div>

        <!-- Button -->
        <div class="form-group mb-3">
            <button type="submit" class="btn submit-btn w-100 text-white">
                Sign In
            </button>
        </div>

        <!-- Remember + Forgot -->
        <div class="d-flex justify-content-between align-items-center extra-links mb-3">
            <label>
                <input type="checkbox"> Remember me
            </label>

            <a href="{{ route('password.request') }}">Forgot Password?</a>
        </div>

        <hr>

        <!-- Register -->
        <div class="text-center extra-links">
            Don't have an account?
            <a href="{{ url('/register') }}">Create account</a>
        </div>
    </form>
</div>

<script>
    function togglePassword() {
        let password = document.getElementById("password");
        let icon = document.getElementById("toggleIcon");

        if (password.type === "password") {
            password.type = "text";
            icon.classList.remove("mdi-eye-off");
            icon.classList.add("mdi-eye");
        } else {
            password.type = "password";
            icon.classList.remove("mdi-eye");
            icon.classList.add("mdi-eye-off");
        }
    }
</script>
@endsection
