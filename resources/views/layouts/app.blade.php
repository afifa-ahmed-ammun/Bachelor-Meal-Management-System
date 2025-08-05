<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bachelor Meal Management System')</title>
    <style>
        :root {
            --light-bg: #F3F3E0;
            --primary: #27548a;
            --dark-primary: #27548a;
            --accent: #DDA853;
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.18);
            --error: #ff6b6b;
            --success: #51cf66;
            --warning: #ffd43b;
            --text: #2B3674;
            --text-light: #666666;
            --border: #cccccc;
        }

        /* Base Styles */
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-primary);
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            line-height: 1.6;
        }

        /* Navigation */
        nav.glass-card {
            width: 100%;
            border-radius: 0;
            margin-top: 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .nav-logo {
            font-weight: bold;
            font-size: 1.5rem;
            text-decoration: none;
            color: var(--primary);
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark-primary);
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--accent);
        }

        /* Glass Card */
        .glass-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 1rem;
            padding: 2rem;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 1200px;
            margin: 1rem auto;
        }

        /* Forms */
        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            width: 100%;
        }

        .centered-form {
            max-width: 400px;
            width: 90%;
        }

        .centered-form h2 {
            text-align: center;
            color: var(--primary);
            margin-bottom: 2rem;
        }

        .centered-form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark-primary);
        }

        .centered-form input,
        .centered-form select {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            font-size: 1rem;
            box-sizing: border-box;
        }

        .centered-form button {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .centered-form button:hover {
            background-color: var(--dark-primary);
        }

        .centered-form p {
            text-align: center;
            margin-top: 1rem;
        }

        .centered-form a {
            color: var(--primary);
            text-decoration: none;
        }

        .centered-form a:hover {
            text-decoration: underline;
        }

        /* Alerts */
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
            border: 1px solid;
        }

        .alert-danger {
            color: var(--error);
            background-color: rgba(255, 107, 107, 0.1);
            border-color: var(--error);
        }

        .alert-success {
            color: var(--success);
            background-color: rgba(81, 207, 102, 0.1);
            border-color: var(--success);
        }

        /* Hero Section */
        .hero-section {
            text-align: center;
            padding: 4rem 2rem;
            margin: 1rem auto 2rem auto;
        }

        .hero-content h1 {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.1rem;
            color: var(--text-light);
            margin-bottom: 2rem;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .button {
            padding: 0.7rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            min-width: 120px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            background-color: var(--primary);
            color: white;
        }

        .button:hover {
            background-color: var(--dark-primary);
            transform: translateY(-2px);
        }

        /* Features */
        .features-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .feature-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-item h3 {
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .section-heading {
            text-align: center;
            color: var(--primary);
            font-size: 2rem;
            margin-bottom: 2rem;
        }

        .about-content {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }

        .about-content p {
            margin-bottom: 1rem;
            color: var(--text-light);
        }

        /* Dashboard Styles */
        .dashboard-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .dashboard-header h1 {
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary);
        }

        .stat-label {
            color: var(--text-light);
            margin-top: 0.5rem;
        }

        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .content-section {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 1.5rem;
        }

        .content-section h3 {
            color: var(--primary);
            margin-bottom: 1rem;
            text-align: center;
        }

        .list-item {
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .list-item:last-child {
            border-bottom: none;
        }

        .logout-btn {
            background-color: var(--error);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .logout-btn:hover {
            background-color: #e55555;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="glass-card">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="nav-logo">Meal Manager</a>
            <div class="nav-links">
                @guest
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('signup') }}">Signup</a>
                @else
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    @if(Auth::user()->isMember())
                        <a href="{{ route('user.meals') }}">My Meals</a>
                        <a href="{{ route('user.payments') }}">Payments</a>
                    @endif
                    <span>Welcome, {{ Auth::user()->getFullNameAttribute() }}</span>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="glass-card">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="glass-card">
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    @yield('content')
</body>
</html>
