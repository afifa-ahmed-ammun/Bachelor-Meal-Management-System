@extends('layouts.app')

@section('title', 'My Meals - Bachelor Meal System')

@section('content')
<main class="glass-card">
    <header style="text-align: center; margin-bottom: 2rem;">
        <h1 style="color: var(--primary); margin-bottom: 1rem;">Meal Management</h1>
        <p>Schedule your meals and view your cooking history</p>
    </header>

    <!-- Add Meal Form -->
    <section class="content-section">
        <h2>Add a Meal</h2>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 1rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.meals.store') }}" method="POST">
            @csrf
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <label for="meal_name" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Meal Name</label>
                    <input type="text" id="meal_name" name="meal_name" 
                           style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: 5px; font-size: 1rem;" 
                           placeholder="e.g., Rice with Fish Curry" value="{{ old('meal_name') }}" required>
                </div>
                
                <div>
                    <label for="meal_type" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Meal Type</label>
                    <select id="meal_type" name="meal_type" 
                            style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: 5px; font-size: 1rem;" required>
                        <option value="">Select meal type</option>
                        <option value="breakfast" {{ old('meal_type') == 'breakfast' ? 'selected' : '' }}>Breakfast</option>
                        <option value="lunch" {{ old('meal_type') == 'lunch' ? 'selected' : '' }}>Lunch</option>
                        <option value="dinner" {{ old('meal_type') == 'dinner' ? 'selected' : '' }}>Dinner</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <label for="date" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Date</label>
                    <input type="date" id="date" name="date" 
                           style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: 5px; font-size: 1rem;" 
                           value="{{ old('date', date('Y-m-d')) }}" required>
                </div>
                
                <div>
                    <label for="quantity" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Quantity (Servings)</label>
                    <input type="number" id="quantity" name="quantity" 
                           style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: 5px; font-size: 1rem;" 
                           min="1" value="{{ old('quantity', 1) }}" required>
                </div>
                
                <div>
                    <label for="price" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Price per Serving (৳)</label>
                    <input type="number" id="price" name="price" 
                           style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: 5px; font-size: 1rem;" 
                           min="0" step="0.01" value="{{ old('price') }}" required>
                </div>
            </div>

            <button type="submit" class="button" style="width: 100%; background-color: var(--primary); color: white; border: none; padding: 0.75rem; border-radius: 5px; font-size: 1rem; cursor: pointer;">
                Add Meal
            </button>
        </form>
    </section>

    <!-- Content Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem; margin-top: 2rem;">
        
        <!-- My Meals -->
        <div class="content-section">
            <h3>My Recent Meals</h3>
            @if($myMeals->count() > 0)
                @foreach($myMeals as $meal)
                    <div class="list-item">
                        <strong>{{ $meal->meal_name }}</strong><br>
                        Type: {{ ucfirst($meal->meal_type) }}<br>
                        Date: {{ $meal->date ? $meal->date->format('M d, Y') : 'N/A' }}<br>
                        Quantity: {{ $meal->quantity }} serving(s)<br>
                        Price: ৳{{ number_format($meal->price, 2) }} per serving<br>
                        <small style="color: var(--text-light);">
                            Added {{ $meal->created_at->diffForHumans() }}
                        </small>
                    </div>
                @endforeach
            @else
                <p>You haven't added any meals yet.</p>
            @endif
        </div>

        <!-- Recent Community Meals -->
        <div class="content-section">
            <h3>Recent Community Meals</h3>
            @if($recentMeals->count() > 0)
                @foreach($recentMeals as $meal)
                    <div class="list-item">
                        <strong>{{ $meal->meal_name }}</strong><br>
                        Cook: {{ $meal->user->getFullNameAttribute() ?? 'Unknown' }}<br>
                        Type: {{ ucfirst($meal->meal_type) }}<br>
                        Date: {{ $meal->date ? $meal->date->format('M d, Y') : 'N/A' }}<br>
                        Price: ৳{{ number_format($meal->price, 2) }} per serving<br>
                        @if($meal->averageRating())
                            <span style="color: var(--accent);">
                                Rating: {{ number_format($meal->averageRating(), 1) }}/5 ⭐
                            </span>
                        @endif
                    </div>
                @endforeach
            @else
                <p>No recent meals found.</p>
            @endif
        </div>

        <!-- Available Inventory -->
        <div class="content-section">
            <h3>Available Ingredients</h3>
            @if($inventory->count() > 0)
                @foreach($inventory as $item)
                    <div class="list-item">
                        <strong>{{ $item->item_name }}</strong><br>
                        Available: {{ $item->quantity }} {{ $item->unit }}<br>
                        Price: ৳{{ number_format($item->price, 2) }}<br>
                        @if($item->quantity <= $item->threshold)
                            <span style="color: var(--error);">⚠️ Low Stock</span>
                        @else
                            <span style="color: var(--success);">✅ In Stock</span>
                        @endif
                    </div>
                @endforeach
            @else
                <p>No inventory items available.</p>
            @endif
        </div>

    </div>

    <!-- Cooking Tips -->
    <section class="content-section" style="margin-top: 2rem; text-align: center; background: rgba(255, 255, 255, 0.05);">
        <h3>Cooking Tips</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 1rem;">
            <div>
                <strong>🍚 Rice Tips</strong><br>
                <small>Use 1:1.5 rice to water ratio for perfect rice</small>
            </div>
            <div>
                <strong>🐟 Fish Preparation</strong><br>
                <small>Marinate fish 30 mins before cooking</small>
            </div>
            <div>
                <strong>🥬 Vegetables</strong><br>
                <small>Don't overcook - keep them crispy and nutritious</small>
            </div>
            <div>
                <strong>🧂 Seasoning</strong><br>
                <small>Season gradually and taste as you go</small>
            </div>
        </div>
    </section>
</main>

<script>
// Set minimum date to today
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('date');
    const today = new Date().toISOString().split('T')[0];
    dateInput.setAttribute('min', today);
});
</script>
@endsection
