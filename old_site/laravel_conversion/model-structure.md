# Database Model Structure and Relationships

This guide outlines the structure of each model and their relationships in the Laravel implementation of the Bachelor Meal System.

## User Model

```php
class User extends Authenticatable
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'room_number',
        'password',
        'role',
    ];

    // Relationships
    public function bazarSchedules()
    {
        return $this->hasMany(BazarSchedule::class);
    }

    public function inventoryItems()
    {
        return $this->hasMany(Inventory::class);
    }

    public function inventoryRequests()
    {
        return $this->hasMany(InventoryRequest::class, 'requested_by');
    }

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }

    public function mealRatings()
    {
        return $this->hasMany(MealRating::class);
    }

    public function userNotifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function scheduledMeals()
    {
        return $this->hasMany(ScheduledMeal::class);
    }
}
```

## BazarSchedule Model

```php
class BazarSchedule extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

## CookAbsence Model

```php
class CookAbsence extends Model
{
    protected $fillable = [
        'date',
        'reason',
        'approved_by',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relationships
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
```

## Inventory Model

```php
class Inventory extends Model
{
    protected $fillable = [
        'user_id',
        'item_name',
        'quantity',
        'unit',
        'price',
        'threshold',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mealItems()
    {
        return $this->hasMany(MealItem::class, 'item_name', 'item_name');
    }
}
```

## InventoryRequest Model

```php
class InventoryRequest extends Model
{
    protected $fillable = [
        'item_name',
        'quantity',
        'unit_type',
        'price',
        'threshold',
        'status',
        'requested_by',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
    ];

    // Relationships
    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
}
```

## Meal Model

```php
class Meal extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'price',
        'date',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mealItems()
    {
        return $this->hasMany(MealItem::class);
    }

    public function scheduledMeals()
    {
        return $this->hasMany(ScheduledMeal::class);
    }

    public function ratings()
    {
        return $this->hasMany(MealRating::class);
    }
}
```

## MealItem Model

```php
class MealItem extends Model
{
    protected $fillable = [
        'meal_id',
        'item_name',
        'quantity',
    ];

    // Relationships
    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'item_name', 'item_name');
    }
}
```

## MealRating Model

```php
class MealRating extends Model
{
    protected $fillable = [
        'meal_id',
        'user_id',
        'rating',
    ];

    // Relationships
    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

## Notification Model

```php
class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

## Payment Model

```php
class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'method',
        'transaction_id',
        'status',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

## ScheduledMeal Model

```php
class ScheduledMeal extends Model
{
    protected $fillable = [
        'user_id',
        'meal_id',
        'scheduled_date',
        'meal_time',
        'quantity',
        'total_price',
        'status',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }
}
```

## Migration Structure

Here's the structure for each migration file to create these tables:

### BazarSchedules Migration

```php
Schema::create('bazar_schedules', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->date('date');
    $table->string('status')->default('assigned');
    $table->timestamps();
});
```

### CookAbsences Migration

```php
Schema::create('cook_absences', function (Blueprint $table) {
    $table->id();
    $table->date('date');
    $table->string('reason')->nullable();
    $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
    $table->timestamps();
});
```

### Inventory Migration

```php
Schema::create('inventory', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('item_name');
    $table->decimal('quantity', 10, 2)->default(0);
    $table->string('unit', 10);
    $table->decimal('price', 10, 2)->default(0);
    $table->decimal('threshold', 10, 2)->default(0);
    $table->timestamps();
});
```

### InventoryRequests Migration

```php
Schema::create('inventory_requests', function (Blueprint $table) {
    $table->id();
    $table->string('item_name');
    $table->decimal('quantity', 10, 2);
    $table->string('unit_type', 10);
    $table->decimal('price', 10, 2);
    $table->decimal('threshold', 10, 2);
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
    $table->foreignId('requested_by')->constrained('users')->onDelete('cascade');
    $table->timestamp('requested_at')->useCurrent();
    $table->timestamps();
});
```

### Meals Migration

```php
Schema::create('meals', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
    $table->string('name');
    $table->decimal('price', 10, 2);
    $table->date('date');
    $table->enum('status', ['active', 'inactive'])->default('active');
    $table->timestamps();
});
```

### MealItems Migration

```php
Schema::create('meal_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('meal_id')->constrained()->onDelete('cascade');
    $table->string('item_name');
    $table->decimal('quantity', 10, 2);
    $table->timestamps();
});
```

### MealRatings Migration

```php
Schema::create('meal_ratings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('meal_id')->constrained()->onDelete('cascade');
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->integer('rating')->check('rating between 1 and 5');
    $table->timestamps();
});
```

### Notifications Migration

```php
Schema::create('notifications', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
    $table->enum('type', ['emergency', 'reminder']);
    $table->string('title', 100);
    $table->text('message')->nullable();
    $table->timestamps();
});
```

### Payments Migration

```php
Schema::create('payments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->decimal('amount', 10, 2);
    $table->enum('method', ['cash', 'bkash', 'nagad', 'card']);
    $table->string('transaction_id', 100)->nullable();
    $table->enum('status', ['paid', 'pending'])->default('pending');
    $table->date('date');
    $table->timestamps();
});
```

### ScheduledMeals Migration

```php
Schema::create('scheduled_meals', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('meal_id')->constrained()->onDelete('cascade');
    $table->date('scheduled_date');
    $table->enum('meal_time', ['breakfast', 'lunch', 'dinner']);
    $table->integer('quantity')->default(1);
    $table->decimal('total_price', 10, 2);
    $table->enum('status', ['active', 'cancelled'])->default('active');
    $table->timestamps();
});
```
