@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="dashboard-header">
        <h1 class="section-heading">Admin Dashboard</h1>
    </div>
    
    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-value">{{ $activeUsers }}</div>
            <div class="stat-label">Active Members</div>
        </div>

        <div class="stat-card">
            <div class="stat-value">{{ $todayMeals }}</div>
            <div class="stat-label">Today's Meals</div>
        </div>

        <div class="stat-card">
            <div class="stat-value">{{ $pendingBazarCount }}</div>
            <div class="stat-label">Pending Bazar</div>
        </div>

        <div class="stat-card">
            <div class="stat-value">{{ $pendingInventoryRequests }}</div>
            <div class="stat-label">Inventory Requests</div>
        </div>

        <div class="stat-card">
            <div class="stat-value">{{ $pendingPayments }}</div>
            <div class="stat-label">Pending Payments</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="glass-card">
                <h2 class="section-heading">Upcoming Bazar Schedule</h2>
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Member</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($upcomingBazar as $bazar)
                            <tr>
                                <td>{{ $bazar->date->format('M j, Y') }}</td>
                                <td>{{ $bazar->user->full_name }}</td>
                                <td>
                                    <span class="badge badge-{{ $bazar->status }}">
                                        {{ ucfirst($bazar->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.bazar-schedule.edit', $bazar) }}" class="custom-btn custom-btn-sm">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No upcoming bazar schedules found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3 text-center">
                    <a href="{{ route('admin.bazar-schedule.index') }}" class="custom-btn custom-btn-primary">Manage Bazar</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="glass-card">
                <h2 class="section-heading">Recent Payments</h2>
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Member</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentPayments as $payment)
                            <tr>
                                <td>{{ $payment->date->format('M j, Y') }}</td>
                                <td>{{ $payment->user->full_name }}</td>
                                <td>৳{{ number_format($payment->amount, 2) }}</td>
                                <td>{{ ucfirst($payment->method) }}</td>
                                <td>
                                    <span class="badge badge-{{ $payment->status }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No recent payments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3 text-center">
                    <a href="{{ route('admin.payments.index') }}" class="custom-btn custom-btn-primary">View All Payments</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="glass-card mt-4">
        <h2 class="section-heading">Create New Meal</h2>
        <form action="{{ route('admin.meals.store') }}" method="POST" class="meal-form">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="custom-form-group">
                        <label class="custom-form-label">Date</label>
                        <input type="date" name="date" class="custom-form-control" required min="{{ date('Y-m-d') }}">
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="custom-form-group">
                        <label class="custom-form-label">Meal Name</label>
                        <input type="text" name="name" class="custom-form-control" required placeholder="e.g., Chicken Biryani">
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="custom-form-group">
                        <label class="custom-form-label">Price per Person</label>
                        <input type="number" name="price" class="custom-form-control" required step="0.01" min="0">
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
                <button type="submit" class="custom-btn custom-btn-primary">Create Meal</button>
            </div>
        </form>
    </div>
@endsection
