@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="dashboard-header">
        <h1 class="section-heading">Welcome, {{ Auth::user()->first_name }}</h1>
    </div>
    
    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-value">{{ $scheduledMeals }}</div>
            <div class="stat-label">Scheduled Meals</div>
        </div>

        <div class="stat-card">
            <div class="stat-value">৳{{ number_format($totalDue, 2) }}</div>
            <div class="stat-label">Total Due</div>
        </div>

        <div class="stat-card">
            <div class="stat-value">{{ $nextBazarDate ? $nextBazarDate->date->format('M j') : 'None' }}</div>
            <div class="stat-label">Next Bazar</div>
        </div>
    </div>

    <div class="glass-card">
        <h2 class="section-heading">Recent Meals</h2>
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Meal Type</th>
                    <th>Meal</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentMeals as $meal)
                    <tr>
                        <td>{{ $meal->scheduled_date->format('M j, Y') }}</td>
                        <td>
                            <span class="meal-time meal-time-{{ $meal->meal_time }}">
                                {{ ucfirst($meal->meal_time) }}
                            </span>
                        </td>
                        <td>{{ $meal->meal->name }}</td>
                        <td>{{ $meal->quantity }}</td>
                        <td>৳{{ number_format($meal->total_price, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No recent meals found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3 text-center">
            <a href="{{ route('meals.index') }}" class="custom-btn custom-btn-primary">View All Meals</a>
        </div>
    </div>
@endsection
