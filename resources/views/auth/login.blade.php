<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #ffffff;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: "Poppins", sans-serif;
      color: #1f1f1f;
    }

    .login-container {
      width: 100%;
      max-width: 400px;
      padding: 2rem;
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(54, 57, 58, 0.1);
      border: 1px solid #e0e0e0;
      transition: all 0.3s ease;
    }

    .login-container:hover {
      box-shadow: 0 10px 25px rgba(54, 57, 58, 0.15);
      transform: translateY(-3px);
    }

    .login-header {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .login-header h2 {
      color: #36393a;
      font-weight: 600;
      letter-spacing: 0.5px;
    }

    .login-header p {
      color: #7a7a7a;
      font-size: 0.95rem;
    }

    .form-control {
      border-radius: 10px;
      border: 1px solid #7a7a7a;
      background-color: #ffffff;
      color: #1f1f1f;
      transition: all 0.2s ease-in-out;
    }

    .form-control:focus {
      border-color: #676868;
      box-shadow: 0 0 0 0.2rem rgba(103, 104, 104, 0.25);
    }

    .form-check-label {
      color: #676868;
      font-size: 0.9rem;
    }

    .btn-login {
      background-color: #36393a;
      color: #ffffff;
      border: none;
      border-radius: 10px;
      padding: 0.6rem 0;
      font-weight: 500;
      transition: all 0.25s ease;
    }

    .btn-login:hover {
      background-color: #676868;
      transform: translateY(-2px);
    }

    .alert {
      border-radius: 10px;
      background-color: #fdecea;
      color: #1f1f1f;
      border: none;
    }

    footer {
      position: absolute;
      bottom: 15px;
      width: 100%;
      text-align: center;
      color: #7a7a7a;
      font-size: 0.85rem;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-header">
      <h2>Admin Login</h2>
      <p>Silakan masuk untuk melanjutkan</p>
    </div>

    @if($errors->any())
      <div class="alert alert-danger small">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="mb-3">
        <label for="email" class="form-label fw-semibold">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" 
               id="email" name="email" value="{{ old('email') }}" required autofocus>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label fw-semibold">Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" 
               id="password" name="password" required>
      </div>

      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember" name="remember">
        <label class="form-check-label" for="remember">Ingat saya</label>
      </div>

      <button type="submit" class="btn btn-login w-100">Masuk</button>
    </form>
  </div>

  <footer>
    &copy; {{ date('Y') }} Admin Panel. Semua hak dilindungi.
  </footer>
</body>
</html>
