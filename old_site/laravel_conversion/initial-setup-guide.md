# Initial Laravel Project Setup Guide

This guide provides step-by-step instructions for setting up your Laravel project for the Bachelor Meal System.

## Step 1: Create a New Laravel Project

Open your terminal/command prompt and navigate to your XAMPP htdocs directory:

```bash
cd c:\xampp\htdocs\
```

Create a new Laravel project using Composer:

```bash
composer create-project laravel/laravel bachelor_meal_system_laravel
```

## Step 2: Configure Database

1. Create a new database in MySQL named `bachelor_meal_system_laravel`

2. Open the `.env` file in the root of your Laravel project and update the database configuration:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bachelor_meal_system_laravel
DB_USERNAME=root
DB_PASSWORD=
```

## Step 3: Install Required Packages

```bash
cd bachelor_meal_system_laravel

# Install Laravel UI for authentication scaffolding
composer require laravel/ui

# Install Bootstrap with auth scaffolding
php artisan ui bootstrap --auth

# Install NPM dependencies and compile assets
npm install
npm run dev
```

## Step 4: Create Authentication System

Laravel UI has already scaffolded the authentication system. Run the migrations to create the initial users table:

```bash
php artisan migrate
```

## Step 5: Modify the User Model

Edit the User model to match our requirements:

1. Update `app/Models/User.php`:

```php
<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'room_number',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
    
    /**
     * Get the bazar schedules for the user.
     */
    public function bazarSchedules()
    {
        return $this->hasMany(BazarSchedule::class);
    }
    
    /**
     * Get the inventory items created by the user.
     */
    public function inventoryItems()
    {
        return $this->hasMany(Inventory::class);
    }
    
    /**
     * Get the inventory requests made by the user.
     */
    public function inventoryRequests()
    {
        return $this->hasMany(InventoryRequest::class, 'requested_by');
    }
    
    /**
     * Get the meals created by the user.
     */
    public function meals()
    {
        return $this->hasMany(Meal::class);
    }
    
    /**
     * Get the meal ratings given by the user.
     */
    public function mealRatings()
    {
        return $this->hasMany(MealRating::class);
    }
    
    /**
     * Get the notifications for the user.
     */
    public function userNotifications()
    {
        return $this->hasMany(Notification::class);
    }
    
    /**
     * Get the payments made by the user.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
    /**
     * Get the scheduled meals for the user.
     */
    public function scheduledMeals()
    {
        return $this->hasMany(ScheduledMeal::class);
    }
}
```

2. Create a migration to update the users table:

```bash
php artisan make:migration update_users_table --table=users
```

Edit the migration file to add the necessary fields:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rename name to first_name
            $table->renameColumn('name', 'first_name');
            
            // Add additional fields
            $table->string('last_name')->after('first_name');
            $table->string('phone')->nullable()->after('email');
            $table->string('room_number')->nullable()->after('phone');
            $table->enum('role', ['admin', 'member'])->default('member')->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('first_name', 'name');
            $table->dropColumn(['last_name', 'phone', 'room_number', 'role']);
        });
    }
};
```

3. Create a middleware for admin access control:

```bash
php artisan make:middleware AdminMiddleware
```

Edit the middleware file:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        return redirect()->route('dashboard')->with('error', 'Unauthorized access. Admin privileges required.');
    }
}
```

4. Register the middleware in `app/Http/Kernel.php`:

```php
protected $routeMiddleware = [
    // Other middlewares...
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
];
```

## Step 6: Create Basic Routes

Edit `routes/web.php`:

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes are automatically included by Laravel UI

// User routes (authenticated)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // More user routes will be added in Sprint 1
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    // More admin routes will be added in Sprint 1
});
```

## Step 7: Create Dashboard Controllers

```bash
php artisan make:controller DashboardController
php artisan make:controller Admin/DashboardController
```

Edit the DashboardController:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function index(): View
    {
        return view('dashboard');
    }
}
```

Edit the Admin DashboardController:

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        return view('admin.dashboard');
    }
}
```

## Step 8: Create View Files

Create the following directories:
```bash
mkdir -p resources/views/admin
mkdir -p resources/views/meals
mkdir -p resources/views/inventory
mkdir -p resources/views/payments
mkdir -p resources/views/bazar
```

Create a basic layout file:
```blade
<!-- resources/views/layouts/app.blade.php is created by Laravel UI -->
```

Create basic dashboard views:
```bash
touch resources/views/dashboard.blade.php
touch resources/views/admin/dashboard.blade.php
```

## Step 9: Run Your Application

Start the development server:

```bash
php artisan serve
```

Visit http://localhost:8000 in your browser to see your Laravel application.

## Next Steps

1. Complete the user authentication modification
2. Implement the user management system
3. Create the admin panel
4. Develop the dashboard interfaces
