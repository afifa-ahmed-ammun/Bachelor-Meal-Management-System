<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\ScheduledMeal;
use App\Models\BazarSchedule;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();
        
        // Get scheduled meals count
        $scheduledMeals = $user->scheduledMeals()
            ->where('scheduled_date', '>=', now())
            ->where('status', 'active')
            ->count();
            
        // Get total due (amount user needs to pay)
        $totalDue = $user->scheduledMeals()
            ->where('status', 'active')
            ->sum('total_price');
            
        // Get next bazar duty
        $nextBazarDate = $user->bazarSchedules()
            ->where('date', '>=', now())
            ->where('status', 'assigned')
            ->orderBy('date')
            ->first();
            
        // Get recent meals
        $recentMeals = $user->scheduledMeals()
            ->with('meal')
            ->where('status', 'active')
            ->orderBy('scheduled_date', 'desc')
            ->limit(5)
            ->get();
            
        return view('dashboard', compact(
            'scheduledMeals',
            'totalDue',
            'nextBazarDate',
            'recentMeals'
        ));
    }
}
