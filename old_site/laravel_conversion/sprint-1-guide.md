# Sprint 1 Implementation Guide: Core System Setup and User Management

## Pre-requisites
- Composer installed on your system
- PHP 8.1 or higher
- MySQL database
- XAMPP/WAMP/LAMP server
- Node.js and NPM for frontend assets

## Step 1: Laravel Project Setup
1. Open a terminal in your XAMPP htdocs folder and run:
```bash
composer create-project laravel/laravel bachelor_meal_system_laravel
cd bachelor_meal_system_laravel
```

2. Configure your `.env` file with database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bachelor_meal_system_laravel
DB_USERNAME=root
DB_PASSWORD=
```

3. Install Laravel UI for authentication scaffolding:
```bash
composer require laravel/ui
php artisan ui bootstrap --auth
npm install && npm run dev
```

## Step 2: Database Migrations
Create migrations for all tables based on the existing schema:

1. Create User migration (modify default Laravel migration):
```bash
php artisan make:migration update_users_table --table=users
```

2. Create other migrations:
```bash
php artisan make:migration create_bazar_schedules_table
php artisan make:migration create_cook_absences_table
php artisan make:migration create_inventory_table
php artisan make:migration create_inventory_requests_table
php artisan make:migration create_meals_table
php artisan make:migration create_meal_ratings_table
php artisan make:migration create_notifications_table
php artisan make:migration create_payments_table
php artisan make:migration create_scheduled_meals_table
php artisan make:migration create_meal_items_table
```

3. Define the schema for each migration file based on the existing database structure

## Step 3: Create Models with Relationships
```bash
php artisan make:model BazarSchedule
php artisan make:model CookAbsence
php artisan make:model Inventory
php artisan make:model InventoryRequest
php artisan make:model Meal
php artisan make:model MealRating
php artisan make:model Notification
php artisan make:model Payment
php artisan make:model ScheduledMeal
php artisan make:model MealItem
```

Define relationships in each model:
- User has many BazarSchedules, Inventories, InventoryRequests, etc.
- Meal belongs to User
- etc.

## Step 4: Authentication and User Management
1. Customize the User model to match our requirements
2. Create roles and permissions for admin and regular users
3. Create user management controller for admins
4. Implement middleware for role-based access control

## Step 5: Create Controllers for User Management
```bash
php artisan make:controller Admin/UserController --resource
php artisan make:controller UserProfileController
```

## Step 6: Create Blade Views
1. Create layout templates with common components
2. Create user dashboard views
3. Create admin dashboard views
4. Create user management views (for admins)

## Step 7: Define Routes
In `routes/web.php`:
1. Define authentication routes
2. Define user routes
3. Define admin routes with middleware for access control

## Step 8: Create Seeders for Testing
```bash
php artisan make:seeder UsersTableSeeder
php artisan make:seeder MealsTableSeeder
```

## Step 9: Testing
1. Create unit tests for models and controllers
2. Create feature tests for authentication flows

## Step 10: UI Implementation
1. Implement responsive design with Bootstrap 5
2. Create custom CSS based on the existing style
3. Ensure consistent look and feel across all pages

## End of Sprint Deliverables
- Fully functional authentication system
- User and admin dashboards
- User management functionality for admins
- Database structure for all features
- UI templates for the entire application
