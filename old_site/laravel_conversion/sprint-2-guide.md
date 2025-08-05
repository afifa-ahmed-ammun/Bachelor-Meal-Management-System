# Sprint 2 Implementation Guide: Meal and Inventory Management

## Pre-requisites
- Completed Sprint 1 with fully functional authentication and user management
- Database migrations and models are set up

## Step 1: Meal Management System

### 1.1 Create Controllers
```bash
php artisan make:controller MealController --resource
php artisan make:controller ScheduledMealController --resource
php artisan make:controller MealRatingController
```

### 1.2 Define Routes in `routes/web.php`
```php
// Meal management routes
Route::middleware(['auth'])->group(function () {
    Route::resource('meals', MealController::class);
    Route::resource('scheduled-meals', ScheduledMealController::class);
    Route::post('meal-ratings', [MealRatingController::class, 'store'])->name('meal-ratings.store');
});

// Admin-specific meal routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/meals', [MealController::class, 'adminIndex'])->name('admin.meals.index');
    Route::post('admin/meals', [MealController::class, 'adminStore'])->name('admin.meals.store');
    // Additional admin meal routes...
});
```

### 1.3 Implement Controllers
1. MealController: Create, read, update, delete meals
2. ScheduledMealController: Schedule, view, modify meals
3. MealRatingController: Add and update meal ratings

### 1.4 Create Views
1. Admin meal creation view
2. User meal scheduling view
3. Meal history view
4. Meal rating components

### 1.5 Implement Form Requests
```bash
php artisan make:request StoreMealRequest
php artisan make:request StoreScheduledMealRequest
```

## Step 2: Inventory Management System

### 2.1 Create Controllers
```bash
php artisan make:controller InventoryController --resource
php artisan make:controller InventoryRequestController --resource
```

### 2.2 Define Routes in `routes/web.php`
```php
// Inventory management routes
Route::middleware(['auth'])->group(function () {
    Route::resource('inventory', InventoryController::class)->only(['index', 'show']);
    Route::resource('inventory-requests', InventoryRequestController::class);
});

// Admin-specific inventory routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('admin/inventory', InventoryController::class)->except(['index', 'show']);
    Route::post('admin/inventory-requests/{request}/approve', [InventoryRequestController::class, 'approve'])->name('inventory-requests.approve');
    Route::post('admin/inventory-requests/{request}/reject', [InventoryRequestController::class, 'reject'])->name('inventory-requests.reject');
});
```

### 2.3 Implement Controllers
1. InventoryController: Manage inventory items
2. InventoryRequestController: Create, approve, reject inventory requests

### 2.4 Create Views
1. Inventory index view
2. Inventory request form
3. Admin inventory management view
4. Inventory request approval view

### 2.5 Implement Form Requests
```bash
php artisan make:request StoreInventoryRequest
php artisan make:request StoreInventoryRequestRequest
```

## Step 3: API Endpoints for AJAX Functionality

### 3.1 Create API Controllers
```bash
php artisan make:controller API/MealController
php artisan make:controller API/InventoryController
```

### 3.2 Define API Routes in `routes/api.php`
```php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('meals/available', [MealController::class, 'getAvailableMeals']);
    Route::get('inventory/items', [InventoryController::class, 'getItems']);
});
```

### 3.3 Implement JavaScript for Dynamic UI Interactions
1. Meal scheduling with real-time price calculation
2. Inventory item filtering and searching
3. Rating system with AJAX updates

## Step 4: Validation and Error Handling
1. Implement form validations for all inputs
2. Create custom error messages
3. Implement proper error handling for AJAX requests

## Step 5: Implement Policies for Authorization
```bash
php artisan make:policy MealPolicy --model=Meal
php artisan make:policy InventoryPolicy --model=Inventory
php artisan make:policy InventoryRequestPolicy --model=InventoryRequest
```

## Step 6: Testing
1. Create unit tests for meal and inventory models
2. Create feature tests for meal scheduling flow
3. Create feature tests for inventory request flow
4. Test authorization policies

## End of Sprint Deliverables
- Complete meal management system (create, schedule, view history, rate)
- Complete inventory management system (add/update items, request new items, approve requests)
- AJAX functionality for dynamic interactions
- Validation and error handling
- Authorization policies for access control
- Tests for all implemented features
