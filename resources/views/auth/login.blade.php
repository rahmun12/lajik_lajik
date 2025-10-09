<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --text: #1a1a1a;       /* Hitam gelap */
      --bg: #ffffff;         /* Putih */
      --primary: #6b7280;    /* Gray-500 */
      --secondary: #9ca3af;  /* Gray-400 */
      --border: #d1d5db;     /* Gray netral untuk border */
    }

    * { box-sizing: border-box; }

    body {
      background-color: var(--bg);
      font-family: "Poppins", sans-serif;
      color: var(--text);
      min-height: 100vh;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-wrapper {
      display: flex;
      width: 850px;
      min-height: 500px;
      background: var(--bg);
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.08);
      overflow: hidden;
    }

    /* Bagian kiri */
    .login-left {
      flex: 1;
      background: linear-gradient(135deg, var(--bg), var(--primary));
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 2.5rem;
    }

    .login-left h2 {
      font-size: 2rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
      color: var(--text);
    }

    .login-left p {
      font-size: 1rem;
      color: var(--text);
      opacity: 0.8;
      max-width: 280px;
      line-height: 1.5;
    }

    /* Bagian kanan */
    .login-right {
      flex: 1;
      padding: 3rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .login-right h3 {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 2rem;
      color: var(--text);
    }

    .form-label {
      font-weight: 500;
      color: var(--text);
    }

    .form-control {
      border-radius: 12px;
      border: 1.5px solid var(--border);
      padding: 0.75rem 1rem;
      background-color: var(--bg);
      color: var(--text);
      transition: all 0.2s ease;
    }

    .form-control:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 0.15rem rgba(107,114,128,0.2);
      background-color: var(--bg);
    }

    .btn-login {
      background-color: var(--primary);
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: 0.75rem;
      font-weight: 500;
      transition: all 0.2s ease;
    }

    .btn-login:hover {
      background-color: var(--secondary);
      color: var(--text);
    }

    .form-check-label {
      font-size: 0.9rem;
      color: var(--primary);
      user-select: none;
    }

    .alert {
      background-color: var(--bg);
      border: 1px solid var(--primary);
      color: var(--text);
      border-radius: 10px;
      padding: 0.75rem 1rem;
      font-size: 0.9rem;
      margin-bottom: 1.5rem;
    }

    footer {
      position: absolute;
      bottom: 15px;
      width: 100%;
      text-align: center;
      font-size: 0.85rem;
      color: var(--primary);
    }

    @media (max-width: 768px) {
      .login-wrapper {
        flex-direction: column;
        width: 90%;
      }
      .login-left, .login-right {
        padding: 2rem 1.5rem;
      }
    }
  </style>
</head>
<body>
  <div class="login-wrapper">
    <!-- Kiri -->
    <div class="login-left">
      <h2>Selamat Datang</h2>
      <p>Masuk untuk mengelola data dan pantau aktivitas dengan mudah.</p>
    </div>

    <!-- Kanan -->
    <div class="login-right">
      <h3>Login Admin</h3>

      @if($errors->any())
        <div class="alert">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control @error('email') is-invalid @enderror"
                 id="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
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
  </div>

  <footer>
    &copy; {{ date('Y') }} Admin Panel — Minimal & Professional.
  </footer>
</body>
</html>
