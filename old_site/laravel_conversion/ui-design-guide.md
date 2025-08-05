# UI Design Guide for Laravel Implementation

This guide provides instructions for implementing a consistent user interface across the Bachelor Meal System Laravel application.

## Design Philosophy

The UI design for the Bachelor Meal System will follow the original design principles:
- Clean, modern interface
- Glass-card components with subtle transparency
- Blue and gold accent colors
- Responsive design for all screen sizes

## CSS Framework

We'll use Bootstrap 5 as the base CSS framework, extended with custom styles to match the original design.

## Color Scheme

Create a `_variables.scss` file in `resources/scss/` with the following variables:

```scss
// Color Variables
$light-bg: #F3F3E0;
$primary: #27548A;
$dark-primary: #183B4E;
$accent: #DDA853;
$glass-bg: rgba(255, 255, 255, 0.15);
$glass-border: rgba(255, 255, 255, 0.2);
$text-color: #2C3E50;

// Override Bootstrap Variables
$theme-colors: (
  "primary": $primary,
  "secondary": $accent,
  "light": $light-bg,
  "dark": $dark-primary
);

$body-bg: $light-bg;
$body-color: $text-color;
```

## Layout Components

### Main Layout Template

Create a base layout template in `resources/views/layouts/app.blade.php`:

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | Bachelor Meal System</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-md navbar-light glass-card">
        <div class="container nav-container">
            <a class="navbar-brand nav-logo" href="{{ url('/') }}">
                Meal Manager
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    @auth
                        @if(Auth::user()->isAdmin())
                            @include('layouts.partials.admin-nav')
                        @else
                            @include('layouts.partials.user-nav')
                        @endif
                    @endauth
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->first_name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                </a>
                                
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            @include('layouts.partials.alerts')
            @yield('content')
        </div>
    </main>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
```

### Admin Navigation Partial

Create `resources/views/layouts/partials/admin-nav.blade.php`:

```blade
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}" href="{{ route('admin.inventory.index') }}">Inventory</a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Members</a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.meals.*') ? 'active' : '' }}" href="{{ route('admin.meals.index') }}">Meals</a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.bazar-schedule.*') ? 'active' : '' }}" href="{{ route('admin.bazar-schedule.index') }}">Bazar</a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}" href="{{ route('admin.payments.index') }}">Payments</a>
</li>
```

### User Navigation Partial

Create `resources/views/layouts/partials/user-nav.blade.php`:

```blade
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('meals.*') ? 'active' : '' }}" href="{{ route('meals.index') }}">My Meals</a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}" href="{{ route('inventory.index') }}">Inventory</a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}" href="{{ route('payments.index') }}">Payments</a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('bazar-schedule.*') ? 'active' : '' }}" href="{{ route('bazar-schedule.index') }}">Bazar</a>
</li>
```

### Alerts Partial

Create `resources/views/layouts/partials/alerts.blade.php`:

```blade
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
```

## Custom CSS Components

Create a custom SCSS file in `resources/scss/app.scss`:

```scss
// Import Bootstrap variables
@import 'variables';
@import '~bootstrap/scss/bootstrap';

// Custom styles
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: var(--light-bg);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

// Glass Card
.glass-card {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(5px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

// Navigation
.nav-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 1.5rem;
}

.nav-logo {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--primary) !important;
    text-decoration: none;
}

.nav-links .nav-link {
    color: var(--dark-primary);
    font-weight: 500;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
}

.nav-links .nav-link:hover {
    color: var(--primary);
}

.nav-links .active {
    color: var(--accent);
    font-weight: 600;
}

// Section Headings
.section-heading {
    color: var(--primary);
    font-size: 2rem;
    margin-bottom: 2rem;
    text-align: center;
    position: relative;
}

.section-heading::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 3px;
    background: var(--accent);
}

// Table Styles
.custom-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.custom-table th {
    background: rgba(255, 255, 255, 0.3);
    color: var(--primary);
    font-weight: 600;
    padding: 1rem;
    text-align: left;
    border-bottom: 2px solid rgba(255, 255, 255, 0.5);
}

.custom-table td {
    padding: 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.custom-table tr:hover {
    background: rgba(255, 255, 255, 0.1);
}

// Buttons
.custom-btn {
    background: var(--primary);
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 5px;
    font-weight: 500;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.custom-btn:hover {
    background: var(--dark-primary);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    color: white;
}

.custom-btn-accent {
    background: var(--accent);
    color: var(--dark-primary);
}

.custom-btn-accent:hover {
    background: darken(var(--accent), 10%);
    color: var(--dark-primary);
}

// Form Elements
.custom-form-group {
    margin-bottom: 1.5rem;
}

.custom-form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--dark-primary);
}

.custom-form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 5px;
    background: rgba(255, 255, 255, 0.2);
    color: var(--dark-primary);
    transition: all 0.3s ease;
}

.custom-form-control:focus {
    outline: none;
    border-color: var(--primary);
    background: rgba(255, 255, 255, 0.3);
    box-shadow: 0 0 0 0.25rem rgba(39, 84, 138, 0.25);
}

// Status Badges
.badge-approved {
    background: #28a745;
    color: white;
    padding: 0.35rem 0.65rem;
    border-radius: 0.25rem;
    font-size: 0.75rem;
}

.badge-pending {
    background: #ffc107;
    color: #212529;
    padding: 0.35rem 0.65rem;
    border-radius: 0.25rem;
    font-size: 0.75rem;
}

.badge-rejected {
    background: #dc3545;
    color: white;
    padding: 0.35rem 0.65rem;
    border-radius: 0.25rem;
    font-size: 0.75rem;
}

// Meal time badges
.meal-time {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.75rem;
    font-weight: 600;
}

.meal-time-breakfast {
    background: #8BC34A;
    color: white;
}

.meal-time-lunch {
    background: #FF9800;
    color: white;
}

.meal-time-dinner {
    background: #9C27B0;
    color: white;
}

// Dashboard Cards
.dashboard-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    padding: 1.5rem;
    text-align: center;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 0.5rem;
}

.stat-label {
    color: var(--dark-primary);
    font-size: 1rem;
}

// Responsive Design
@media (max-width: 768px) {
    .nav-container {
        flex-direction: column;
        padding: 1rem;
    }

    .nav-links {
        margin-top: 1rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .section-heading {
        font-size: 1.75rem;
    }
    
    .dashboard-stats {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .section-heading {
        font-size: 1.5rem;
    }
    
    .custom-table {
        display: block;
        overflow-x: auto;
    }
}
```

## Common Blade Components

### Create the following Blade components:

1. Create a button component in `resources/views/components/button.blade.php`:

```blade
@props([
    'type' => 'button',
    'href' => null,
    'variant' => 'primary',
])

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "custom-btn custom-btn-$variant"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "custom-btn custom-btn-$variant"]) }}>
        {{ $slot }}
    </button>
@endif
```

2. Create a card component in `resources/views/components/card.blade.php`:

```blade
@props([
    'title' => null,
])

<div {{ $attributes->merge(['class' => 'glass-card']) }}>
    @if ($title)
        <h2 class="section-heading">{{ $title }}</h2>
    @endif

    {{ $slot }}
</div>
```

3. Create a form-group component in `resources/views/components/form-group.blade.php`:

```blade
@props([
    'label',
    'for',
    'error' => null,
])

<div class="custom-form-group">
    <label for="{{ $for }}" class="custom-form-label">{{ $label }}</label>
    
    {{ $slot }}
    
    @if ($error)
        <div class="text-danger mt-1">{{ $error }}</div>
    @endif
</div>
```

## Usage Examples

### Dashboard View Example

```blade
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
            <div class="stat-value">{{ $nextBazarDate ?? 'None' }}</div>
            <div class="stat-label">Next Bazar</div>
        </div>
    </div>

    <x-card title="Recent Meals">
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
            <x-button href="{{ route('meals.index') }}" variant="primary">View All Meals</x-button>
        </div>
    </x-card>
@endsection
```

### Form Example

```blade
@extends('layouts.app')

@section('title', 'Schedule Meal')

@section('content')
    <x-card title="Schedule Your Meal">
        <form action="{{ route('scheduled-meals.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-4">
                    <x-form-group label="Date" for="meal_date" :error="$errors->first('meal_date')">
                        <input type="date" id="meal_date" name="meal_date" 
                               class="custom-form-control @error('meal_date') is-invalid @enderror"
                               value="{{ old('meal_date') }}" min="{{ date('Y-m-d') }}" required>
                    </x-form-group>
                </div>
                
                <div class="col-md-4">
                    <x-form-group label="Meal Time" for="meal_time" :error="$errors->first('meal_time')">
                        <select id="meal_time" name="meal_time" 
                                class="custom-form-control @error('meal_time') is-invalid @enderror" required>
                            <option value="">Select Time</option>
                            <option value="breakfast" {{ old('meal_time') == 'breakfast' ? 'selected' : '' }}>Breakfast</option>
                            <option value="lunch" {{ old('meal_time') == 'lunch' ? 'selected' : '' }}>Lunch</option>
                            <option value="dinner" {{ old('meal_time') == 'dinner' ? 'selected' : '' }}>Dinner</option>
                        </select>
                    </x-form-group>
                </div>
                
                <div class="col-md-4">
                    <x-form-group label="Select Meal" for="meal_id" :error="$errors->first('meal_id')">
                        <select id="meal_id" name="meal_id" 
                                class="custom-form-control @error('meal_id') is-invalid @enderror"
                                data-price-update="true" required>
                            <option value="" data-price="0">Choose a meal</option>
                            @foreach ($availableMeals as $meal)
                                <option value="{{ $meal->id }}" data-price="{{ $meal->price }}" 
                                        {{ old('meal_id') == $meal->id ? 'selected' : '' }}>
                                    {{ $meal->name }} (৳{{ number_format($meal->price, 2) }})
                                </option>
                            @endforeach
                        </select>
                    </x-form-group>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <x-form-group label="Quantity" for="quantity" :error="$errors->first('quantity')">
                        <input type="number" id="quantity" name="quantity" 
                               class="custom-form-control @error('quantity') is-invalid @enderror"
                               min="1" value="{{ old('quantity', 1) }}" required data-price-update="true">
                    </x-form-group>
                </div>
                
                <div class="col-md-8 d-flex align-items-end">
                    <div class="total-price-display">
                        <strong>Total Price: <span id="total_price">৳0.00</span></strong>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <x-button type="submit" variant="primary">Schedule Meal</x-button>
            </div>
        </form>
    </x-card>
    
@endsection

@section('scripts')
<script>
    function updateTotalPrice() {
        const mealSelect = document.getElementById('meal_id');
        const quantityInput = document.getElementById('quantity');
        const totalPriceDisplay = document.getElementById('total_price');
        
        if (!mealSelect || !quantityInput || !totalPriceDisplay) {
            return;
        }

        try {
            const selectedOption = mealSelect.options[mealSelect.selectedIndex];
            const price = parseFloat(selectedOption.dataset.price) || 0;
            const quantity = parseInt(quantityInput.value) || 1;
            
            const total = (price * quantity).toFixed(2);
            totalPriceDisplay.textContent = '৳' + total;
        } catch (error) {
            console.error('Error calculating price:', error);
            totalPriceDisplay.textContent = '৳0.00';
        }
    }

    // Initialize price calculation
    document.addEventListener('DOMContentLoaded', updateTotalPrice);

    // Add event listeners to elements with the data-price-update attribute
    document.querySelectorAll('[data-price-update="true"]').forEach(el => {
        el.addEventListener('change', updateTotalPrice);
        el.addEventListener('input', updateTotalPrice);
    });
</script>
@endsection
```

## Customizing Bootstrap Components

If you want to maintain the current look and feel of the application, you should:

1. Create custom Blade components for commonly used UI elements (as shown above)
2. Override Bootstrap styles in the app.scss file
3. Use the glass-card class for card-like elements
4. Use the predefined color scheme consistently

## Final Compilation

After creating all the necessary SCSS and JS files, compile them with:

```bash
npm run dev
```

For production:

```bash
npm run prod
```
