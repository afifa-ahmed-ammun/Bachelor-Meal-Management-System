<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard | Bachelor Meal System</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .meals-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
        }
        
        .meals-table th {
            background: var(--primary);
            color: white;
            padding: 1.2rem;
            text-align: left;
            font-weight: 500;
            border-bottom: 2px solid var(--primary);
        }
        
        .meals-table td {
            padding: 1.2rem;
            color: var(--dark-primary);
        }
        
        .meals-table tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.05);
        }

        .meals-table tr:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }

        .view-all-container {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .view-all-button {
            display: inline-block;
            padding: 0.8rem 2rem;
            background: var(--accent);
            color: var(--dark-primary);
            text-decoration: none;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .view-all-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            background: #c49344;
        }
        
        .balance-positive {
            color: #2ecc71;
            font-weight: bold;
        }
        
        .balance-negative {
            color: #e74c3c;
            font-weight: bold;
        }

        .stats-section {
            padding: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            padding: 1rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            transition: transform 0.3s ease;
            position: relative;
            border-left: 4px solid var(--accent);
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: var(--accent);
        }

        /* Only change the value color for balance, keep border accent consistent */
        .balance-positive .stat-value {
            color: #2ecc71;
        }

        .balance-negative .stat-value {
            color: #e74c3c;
        }

        /* Additional styles for responsive design */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }

        /* Animation Effects */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes shimmer {
            100% { left: 100%; }
        }

        /* Container Enhancement */
        .dashboard-container {
            animation: fadeIn 0.5s ease-in-out;
        }

        /* Enhanced Glass Card */
        .glass-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.25);
        }

        /* Enhanced Button Styling */
        .view-all-button {
            position: relative;
            overflow: hidden;
        }

        .view-all-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: shimmer 2s infinite;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="glass-card">
        <div class="nav-container">
            <a href="{{ route('welcome') }}" class="nav-logo">Meal Manager</a>
            <div class="nav-links">
                <a href="{{ route('user.dashboard') }}" class="active">Dashboard</a>
                <a href="#meals">My Meals</a>
                <a href="#inventory">Inventory</a>
                <a href="#payments">Payments</a>
                <a href="#profile">Profile</a>
                <a href="{{ route('logout') }}">Logout</a>
            </div>
        </div>
    </nav>

    <main class="dashboard-container">
        <!-- Dashboard Header -->
        <header class="dashboard-header">
            <h1>
                <span class="welcome-text" style="color: var(--primary);">Welcome,</span>
                <span class="user-name" style="color: var(--accent);">{{ $user_name }}</span>
            </h1>
            <div class="current-date">{{ date('F j, Y') }}</div>
        </header>

        <!-- Notifications Section -->
        <section class="glass-card notifications-section">
            <h2 class="section-heading">Notifications</h2>
            @if($notifications->count() > 0)
                @foreach($notifications as $notification)
                    <div class="notification {{ $notification->type }}">
                        <div class="notification-icon">
                            @switch($notification->type)
                                @case('emergency')
                                    🚨
                                    @break
                                @case('info')
                                    ℹ️
                                    @break
                                @case('warning')
                                    ⚠️
                                    @break
                                @default
                                    📢
                            @endswitch
                        </div>
                        <div class="notification-content">
                            <h3>{{ $notification->title }}</h3>
                            <p>{{ $notification->message }}</p>
                            <div class="notification-time">{{ date('M j, Y h:i A', strtotime($notification->created_at)) }}</div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>No notifications available.</p>
            @endif
        </section>

        <!-- Monthly Overview Section -->
        <section class="glass-card stats-section">
            <h2 class="section-heading">Monthly Overview</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value">{{ $stats['meals_taken'] }}</div>
                    <div class="stat-label">Meals Taken</div>
                </div>
                <div class="stat-card {{ $stats['balance'] >= 0 ? 'balance-positive' : 'balance-negative' }}">
                    <div class="stat-value">
                        ৳{{ number_format($current_balance, 2) }}
                    </div>
                    <div class="stat-label">Current Balance</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{{ $stats['next_bazar'] ? date('F j', strtotime($stats['next_bazar'])) : 'N/A' }}</div>
                    <div class="stat-label">Next Bazar</div>
                </div>
            </div>
        </section>

        <!-- Recent Meals Section -->
        <section class="glass-card recent-meals-section">
            <h2 class="section-heading">Recent Meals</h2>
            <table class="meals-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Meal Time</th>
                        <th>Meal</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @if($recent_meals->count() > 0)
                        @foreach($recent_meals as $meal)
                            <tr>
                                <td>{{ date('M j, Y', strtotime($meal->date)) }}</td>
                                <td>{{ ucfirst($meal->meal_time) }}</td>
                                <td>{{ $meal->name }}</td>
                                <td>{{ $meal->quantity }}</td>
                                <td>৳{{ number_format($meal->price, 2) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" style="text-align: center;">No recent meals found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="view-all-container">
                <a href="#meals" class="view-all-button">View All Meals</a>
            </div>
        </section>
    </main>
</body>
</html>
