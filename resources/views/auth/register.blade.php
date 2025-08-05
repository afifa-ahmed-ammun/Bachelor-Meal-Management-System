<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup - Bachelor Meal System</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
      <h2>Signup</h2>
      
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

      <form action="{{ route('register.process') }}" method="POST">
        @csrf
        
        <label for="firstname">First Name:</label>
        <input type="text" name="firstname" id="firstname" value="{{ old('firstname') }}" required>
        @error('firstname')
          <span class="error-message">{{ $message }}</span>
        @enderror

        <label for="lastname">Last Name:</label>
        <input type="text" name="lastname" id="lastname" value="{{ old('lastname') }}" required>
        @error('lastname')
          <span class="error-message">{{ $message }}</span>
        @enderror

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required>
        @error('email')
          <span class="error-message">{{ $message }}</span>
        @enderror

        <label for="phone">Phone Number:</label>
        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required>
        @error('phone')
          <span class="error-message">{{ $message }}</span>
        @enderror

        <label for="apartment">Apartment Name:</label>
        <input type="text" name="apartment" id="apartment" value="{{ old('apartment') }}" required>
        @error('apartment')
          <span class="error-message">{{ $message }}</span>
        @enderror

        <label for="role">Role:</label>
        <select name="role" id="role" required>
          <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select your role</option>
          <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member</option>
        </select>
        @error('role')
          <span class="error-message">{{ $message }}</span>
        @enderror

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        @error('password')
          <span class="error-message">{{ $message }}</span>
        @enderror

        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>

        <button type="submit">Signup</button>
      </form>
      
      <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
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
    
    .error-message {
      color: #d63031;
      font-size: 0.875rem;
      margin-top: 0.25rem;
      display: block;
    }
  </style>
</body>
</html>