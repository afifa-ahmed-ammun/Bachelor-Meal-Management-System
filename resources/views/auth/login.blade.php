<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login - Bachelor Meal System</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="glass-card">
    <div class="nav-container">
      <a href="{{ route('welcome') }}" class="nav-logo">Meal Manager</a>
      <div class="nav-links">
        <a href="{{ route('welcome') }}">Home</a>
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}">Signup</a>
        <a href="{{ route('welcome') }}#features">Features</a>
        <a href="{{ route('welcome') }}#about">About</a>
      </div>
    </div>
  </nav>

  <main class="center-container">
    <section class="glass-card centered-form">
      <h2>Login</h2>
      
      @if (session('error'))
        <div class="alert alert-error">
          {{ session('error') }}
        </div>
      @endif

      @if (session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

      @if ($errors->any())
        <div class="alert alert-error">
          @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        </div>
      @endif

      <form action="{{ route('login') }}" method="post">
        @csrf
        <label for="role">Role:</label>
        <select name="role" id="role" required>
          <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member</option>
          <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
        </select>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit" class="button">Login</button>
      </form>
      <p>Don't have an account? <a href="{{ route('register') }}">Signup</a></p>
    </section>
  </main>

  <style>
    .alert {
      padding: 1rem;
      margin-bottom: 1rem;
      border-radius: 8px;
      font-weight: 500;
    }
    
    .alert-error {
      background-color: rgba(255, 107, 107, 0.1);
      border: 1px solid #ff6b6b;
      color: #d63031;
    }
    
    .alert-success {
      background-color: rgba(81, 207, 102, 0.1);
      border: 1px solid #51cf66;
      color: #00b894;
    }
  </style>
</body>
</html>
