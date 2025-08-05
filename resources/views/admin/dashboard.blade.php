@extends('layouts.app')

@section('title', 'Admin Dashboard - Bachelor Meal System')

@section('content')
<main class="glass-card">
    <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <p>Welcome back, {{ Auth::user()->getFullNameAttribute() }}!</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $pending_payments }}</div>
            <div class="stat-label">Pending Payments</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $upcoming_bazar }}</div>
            <div class="stat-label">Upcoming Bazar</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $inventory_requests }}</div>
            <div class="stat-label">Inventory Requests</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $active_members }}</div>
            <div class="stat-label">Active Members</div>
        </div>
    </div>

    <!-- Content Sections -->
    <div class="content-grid">
        <!-- Recent Payments -->
        <div class="content-section">
            <h3>Recent Payment Requests</h3>
            @if($recent_payments->count() > 0)
                @foreach($recent_payments as $payment)
                    <div class="list-item">
                        <strong>{{ $payment->user->getFullNameAttribute() ?? 'Unknown User' }}</strong><br>
                        Amount: ৳{{ number_format($payment->amount, 2) }}<br>
                        Method: {{ ucfirst($payment->method) }}<br>
                        Status: <span style="color: {{ $payment->status == 'paid' ? 'var(--success)' : 'var(--warning)' }}">
                            {{ ucfirst($payment->status) }}
                        </span><br>
                        Date: {{ $payment->date ? $payment->date->format('M d, Y') : 'N/A' }}
                    </div>
                @endforeach
            @else
                <p>No recent payments found.</p>
            @endif
        </div>

        <!-- Bazar Schedule -->
        <div class="content-section">
            <h3>Upcoming Bazar Schedule</h3>
            @if($bazar_schedule->count() > 0)
                @foreach($bazar_schedule as $schedule)
                    <div class="list-item">
                        <strong>{{ $schedule->user->getFullNameAttribute() ?? 'Unassigned' }}</strong><br>
                        Date: {{ $schedule->date->format('M d, Y') }}<br>
                        Status: {{ ucfirst($schedule->status) }}
                    </div>
                @endforeach
            @else
                <p>No upcoming bazar schedule found.</p>
            @endif
        </div>

        <!-- Recent Meals -->
        <div class="content-section">
            <h3>Recent Meals</h3>
            @if($recent_meals->count() > 0)
                @foreach($recent_meals as $meal)
                    <div class="list-item">
                        <strong>{{ $meal->meal_name ?? 'Unnamed Meal' }}</strong><br>
                        Cook: {{ $meal->user->getFullNameAttribute() ?? 'Unknown' }}<br>
                        Type: {{ ucfirst($meal->meal_type) }}<br>
                        Date: {{ $meal->date ? $meal->date->format('M d, Y') : 'N/A' }}<br>
                        Price: ৳{{ number_format($meal->price, 2) }}
                    </div>
                @endforeach
            @else
                <p>No recent meals found.</p>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="content-section">
            <h3>Quick Actions</h3>
            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                <a href="#" class="button" style="text-align: center;">Manage Members</a>
                <a href="#" class="button" style="text-align: center;">View Inventory</a>
                <a href="#" class="button" style="text-align: center;">Approve Payments</a>
                <a href="#" class="button" style="text-align: center;">Manage Bazar</a>
            </div>
        </div>
    </div>
</main>
@endsection
