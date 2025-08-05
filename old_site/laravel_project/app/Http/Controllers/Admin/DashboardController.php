<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\ScheduledMeal;
use App\Models\BazarSchedule;
use App\Models\InventoryRequest;
use App\Models\Payment;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        // Get active users count
        $activeUsers = User::where('role', 'member')->count();
        
        // Get scheduled meals count for today
        $todayMeals = ScheduledMeal::whereDate('scheduled_date', today())
            ->where('status', 'active')
            ->count();
            
        // Get pending bazar schedules
        $pendingBazarCount = BazarSchedule::where('status', 'pending')
            ->count();
            
        // Get pending inventory requests
        $pendingInventoryRequests = InventoryRequest::where('status', 'pending')
            ->count();
            
        // Get pending payments
        $pendingPayments = Payment::where('status', 'pending')
            ->count();
            
        // Get upcoming bazar schedule
        $upcomingBazar = BazarSchedule::with('user')
            ->where('date', '>=', today())
            ->orderBy('date')
            ->limit(5)
            ->get();
            
        // Get recent payments
        $recentPayments = Payment::with('user')
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();
            
        return view('admin.dashboard', compact(
            'activeUsers',
            'todayMeals',
            'pendingBazarCount',
            'pendingInventoryRequests',
            'pendingPayments',
            'upcomingBazar',
            'recentPayments'
        ));
    }
}
