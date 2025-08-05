@extends('layouts.app')

@section('title', 'User Dashboard - Bachelor Meal System')

@section('content')
<main class="glass-card">
    <div class="dashboard-header">
        <h1>User Dashboard</h1>
        <p>Welcome back, {{ $user->getFullNameAttribute() }}!</p>
    </div>

    <!-- User Info Card -->
    <div class="content-section" style="margin-bottom: 2rem;">
        <h3>Your Profile</h3>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Phone:</strong> {{ $user->phone }}</p>
        <p><strong>Apartment:</strong> {{ $user->apartment }}</p>
        <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
    </div>

    <!-- Content Sections -->
    <div class="content-grid">
        <!-- My Payments -->
        <div class="content-section">
            <h3>My Recent Payments</h3>
            @if($my_payments->count() > 0)
                @foreach($my_payments as $payment)
                    <div class="list-item">
                        Amount: ৳{{ number_format($payment->amount, 2) }}<br>
                        Method: {{ ucfirst($payment->method) }}<br>
                        Status: <span style="color: {{ $payment->status == 'paid' ? 'var(--success)' : 'var(--warning)' }}">
                            {{ ucfirst($payment->status) }}
                        </span><br>
                        Date: {{ $payment->date ? $payment->date->format('M d, Y') : 'N/A' }}
                    </div>
                @endforeach
            @else
                <p>No payments found.</p>
            @endif
        </div>

        <!-- My Bazar Schedule -->
        <div class="content-section">
            <h3>My Upcoming Bazar Schedule</h3>
            @if($my_bazar_schedule->count() > 0)
                @foreach($my_bazar_schedule as $schedule)
                    <div class="list-item">
                        Date: {{ $schedule->date->format('M d, Y') }}<br>
                        Status: {{ ucfirst($schedule->status) }}
                    </div>
                @endforeach
            @else
                <p>No upcoming bazar schedule assigned to you.</p>
            @endif
        </div>

        <!-- My Meals -->
        <div class="content-section">
            <h3>My Recent Meals</h3>
            @if($my_meals->count() > 0)
                @foreach($my_meals as $meal)
                    <div class="list-item">
                        <strong>{{ $meal->meal_name ?? 'Unnamed Meal' }}</strong><br>
                        Type: {{ ucfirst($meal->meal_type) }}<br>
                        Date: {{ $meal->date ? $meal->date->format('M d, Y') : 'N/A' }}<br>
                        Price: ৳{{ number_format($meal->price, 2) }}
                    </div>
                @endforeach
            @else
                <p>You haven't cooked any meals yet.</p>
            @endif
        </div>

        <!-- Recent Community Meals -->
        <div class="content-section">
            <h3>Recent Community Meals</h3>
            @if($recent_meals->count() > 0)
                @foreach($recent_meals as $meal)
                    <div class="list-item">
                        <strong>{{ $meal->meal_name ?? 'Unnamed Meal' }}</strong><br>
                        Cook: {{ $meal->user->getFullNameAttribute() ?? 'Unknown' }}<br>
                        Type: {{ ucfirst($meal->meal_type) }}<br>
                        Date: {{ $meal->date ? $meal->date->format('M d, Y') : 'N/A' }}<br>
                        @if($meal->averageRating())
                            Rating: {{ number_format($meal->averageRating(), 1) }}/5
                        @endif
                    </div>
                @endforeach
            @else
                <p>No recent meals found.</p>
            @endif
        </div>

        <!-- Available Inventory -->
        <div class="content-section">
            <h3>Available Inventory</h3>
            @if($inventory_items->count() > 0)
                @foreach($inventory_items as $item)
                    <div class="list-item">
                        <strong>{{ $item->item_name }}</strong><br>
                        Quantity: {{ $item->quantity }} {{ $item->unit }}<br>
                        Price: ৳{{ number_format($item->price, 2) }}<br>
                        @if($item->quantity <= $item->threshold)
                            <span style="color: var(--error)">⚠️ Low Stock</span>
                        @endif
                    </div>
                @endforeach
            @else
                <p>No inventory items available.</p>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="content-section">
            <h3>Quick Actions</h3>
            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                <a href="{{ route('user.meals') }}" class="button" style="text-align: center;">Add Meal</a>
                <a href="{{ route('user.payments') }}" class="button" style="text-align: center;">Make Payment</a>
                <a href="#" class="button" style="text-align: center;">Rate Meals</a>
                <a href="#" class="button" style="text-align: center;">Request Inventory</a>
            </div>
        </div>
    </div>
</main>
@endsection
