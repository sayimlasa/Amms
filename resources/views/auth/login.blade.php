<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IAA | Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">
  <!-- Custom Login CSS -->
  <link rel="stylesheet" href="{{ url('css/login.css') }}">
</head>

<body class="hold-transition">
  <div class="login">
    <div class="login-box">
      <div class="login-logo"></div>

      <div class="login-card">
        <div class="login-card-body">
          <p class="login-box-msg">Sign in</p>

          <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Field -->
            <div class="form-group">
              <label for="email">{{ __('Email Address') }}</label>
              <input id="email" type="email" 
                     class="form-control @error('email') is-invalid @enderror" 
                     name="email" value="{{ old('email') }}" 
                     required autocomplete="email" autofocus>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
              @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <!-- Password Field -->
            <div class="form-group">
              <label for="password">{{ __('Password') }}</label>
              <input id="password" type="password" 
                     class="form-control @error('password') is-invalid @enderror" 
                     name="password" required autocomplete="current-password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
              @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <!-- Submit Button -->
            <div class="form-group">
              <button type="submit" class="btn btn-block">
                {{ __('Login') }}
              </button>
            </div>

            <!-- Forgot Password -->
            @if (Route::has('password.request'))
              <p class="resetlink">
                <a href="{{ route('password.request') }}">Forgot your password? Reset!</a>
              </p>
            @endif
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('admin/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
