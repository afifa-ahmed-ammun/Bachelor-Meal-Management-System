<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use App\Models\BazarSchedule;
use App\Models\InventoryRequest;
use App\Models\Inventory;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return $this->redirectBasedOnRole();
    }

    public function adminDashboard()
    {
        $data = [
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'upcoming_bazar' => BazarSchedule::where('date', '>=', now()->toDateString())->count(),
            'inventory_requests' => InventoryRequest::where('status', 'pending')->count(),
            'active_members' => User::where('role', 'member')->count(),
            'recent_payments' => Payment::with('user')
                ->orderBy('date', 'desc')
                ->limit(5)
                ->get(),
            'bazar_schedule' => BazarSchedule::with('user')
                ->orderBy('date', 'asc')
                ->limit(5)
                ->get(),
            'recent_meals' => Meal::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
        ];

        return view('admin.dashboard', $data);
    }

    public function userDashboard()
    {
        $user = Auth::user();
        
        $data = [
            'user' => $user,
            'my_payments' => Payment::where('user_id', $user->id)
                ->orderBy('date', 'desc')
                ->limit(5)
                ->get(),
            'my_bazar_schedule' => BazarSchedule::where('user_id', $user->id)
                ->where('date', '>=', now()->toDateString())
                ->orderBy('date', 'asc')
                ->limit(3)
                ->get(),
            'my_meals' => Meal::where('user_id', $user->id)
                ->orderBy('date', 'desc')
                ->limit(5)
                ->get(),
            'recent_meals' => Meal::with('user')
                ->orderBy('date', 'desc')
                ->limit(5)
                ->get(),
            'inventory_items' => Inventory::orderBy('item_name')
                ->get(),
        ];

        return view('user.dashboard', $data);
    }

    private function redirectBasedOnRole()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }
}
