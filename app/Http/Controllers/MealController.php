<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MealController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user's meals
        $myMeals = Meal::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Get recent community meals
        $recentMeals = Meal::with('user')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        // Get available inventory for meal creation
        $inventory = Inventory::orderBy('item_name')->get();
        
        return view('user.meals', compact('user', 'myMeals', 'recentMeals', 'inventory'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'meal_name' => 'required|string|max:100',
            'meal_type' => 'required|in:breakfast,lunch,dinner',
            'date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            Meal::create([
                'user_id' => Auth::id(),
                'meal_name' => $request->meal_name,
                'meal_type' => $request->meal_type,
                'date' => $request->date,
                'quantity' => $request->quantity,
                'price' => $request->price,
            ]);

            return back()->with('success', 'Meal added successfully!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error adding meal: ' . $e->getMessage());
        }
    }
}
