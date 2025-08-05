# File Mapping: Current System to Laravel MVC

This document maps the current PHP files to their equivalent components in the Laravel MVC architecture.

## Authentication Files
| Current File | Laravel MVC Equivalent |
|-------------|------------------------|
| login.html | resources/views/auth/login.blade.php |
| process_login.php | App\Http\Controllers\Auth\LoginController |
| signup.html | resources/views/auth/register.blade.php |
| process_signup.php | App\Http\Controllers\Auth\RegisterController |
| logout.html | App\Http\Controllers\Auth\LoginController@logout |

## User Management Files
| Current File | Laravel MVC Equivalent |
|-------------|------------------------|
| admin-members.php | App\Http\Controllers\Admin\UserController |
| admin-members.html | resources/views/admin/users/index.blade.php |
| profile.php | App\Http\Controllers\UserProfileController |

## Dashboard Files
| Current File | Laravel MVC Equivalent |
|-------------|------------------------|
| admin-dashboard.php | App\Http\Controllers\Admin\DashboardController |
| admin-dashboard.html | resources/views/admin/dashboard.blade.php |
| user-dashboard.php | App\Http\Controllers\DashboardController |
| user-dashboard.html | resources/views/dashboard.blade.php |
| index.html | resources/views/welcome.blade.php |
| index.php | App\Http\Controllers\HomeController |

## Meal Management Files
| Current File | Laravel MVC Equivalent |
|-------------|------------------------|
| meals.php | App\Http\Controllers\MealController |
| meals.html | resources/views/meals/index.blade.php |
| schedule_meal.php | App\Http\Controllers\ScheduledMealController@store |
| create_meal.php | App\Http\Controllers\Admin\MealController@store |
| update_rating.php | App\Http\Controllers\MealRatingController@store |
| get_available_meals.php | App\Http\Controllers\API\MealController@getAvailableMeals |

## Inventory Management Files
| Current File | Laravel MVC Equivalent |
|-------------|------------------------|
| admin-inventory.php | App\Http\Controllers\Admin\InventoryController |
| admin-inventory.html | resources/views/admin/inventory/index.blade.php |
| inventory.php | App\Http\Controllers\InventoryController |
| inventory.html | resources/views/inventory/index.blade.php |
| add_inventory_request.php | App\Http\Controllers\InventoryRequestController@store |
| check_inventory.php | App\Http\Controllers\API\InventoryController@check |
| process_inventory_request.php | App\Http\Controllers\Admin\InventoryRequestController@process |
| view_requests.php | App\Http\Controllers\InventoryRequestController@index |

## Bazar Management Files
| Current File | Laravel MVC Equivalent |
|-------------|------------------------|
| admin-bazar.php | App\Http\Controllers\Admin\BazarScheduleController |
| bazar.html | resources/views/bazar/index.blade.php |

## Payment Management Files
| Current File | Laravel MVC Equivalent |
|-------------|------------------------|
| admin-payments.php | App\Http\Controllers\Admin\PaymentController |
| payments.php | App\Http\Controllers\PaymentController |
| payments.html | resources/views/payments/index.blade.php |
| process_payment.php | App\Http\Controllers\PaymentController@store |

## Notification Files
| Current File | Laravel MVC Equivalent |
|-------------|------------------------|
| send_notification.php | App\Notifications\SystemNotification |

## Database Connection
| Current File | Laravel MVC Equivalent |
|-------------|------------------------|
| db_connect.php | .env configuration + database.php config |

## Other Files
| Current File | Laravel MVC Equivalent |
|-------------|------------------------|
| style.css | public/css/app.css + resources/scss/app.scss |
| debug.php | Laravel's built-in error handling and logging |
| store.php | Multiple controllers based on functionality |

## Models
| Current Tables | Laravel Eloquent Models |
|--------------|------------------------|
| users | App\Models\User |
| bazar_schedule | App\Models\BazarSchedule |
| cook_absences | App\Models\CookAbsence |
| inventory | App\Models\Inventory |
| inventory_requests | App\Models\InventoryRequest |
| meals | App\Models\Meal |
| meal_ratings | App\Models\MealRating |
| notifications | App\Models\Notification |
| payments | App\Models\Payment |
| scheduled_meals | App\Models\ScheduledMeal |
| meal_items | App\Models\MealItem |
