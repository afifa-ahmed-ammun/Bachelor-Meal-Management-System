<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    public function index()
    {
        // Check if user is logged in
        if (!session('user_id')) {
            return redirect()->route('login');
        }

        $user_id = session('user_id');
        $user_name = session('user_name');

        // Fetch notifications
        $notifications = DB::table('notifications')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();

        // Initialize stats array
        $stats = [
            'meals_taken' => 0,
            'next_bazar' => null,
            'balance' => 0
        ];

        // Fetch user stats
        $stats_data = DB::table('users_table_updated as u')
            ->leftJoin('bazar_schedule as bs', function($join) {
                $join->on('bs.user_id', '=', 'u.id')
                     ->whereRaw('bs.date >= CURDATE()');
            })
            ->leftJoin('meals as sm', function($join) {
                $join->on('sm.user_id', '=', 'u.id')
                     ->whereRaw('MONTH(sm.meal_date) = MONTH(CURDATE())');
            })
            ->where('u.id', $user_id)
            ->select([
                'u.balance',
                'bs.date as next_bazar',
                DB::raw('COUNT(sm.id) as meals_taken')
            ])
            ->groupBy('u.id', 'u.balance', 'bs.date')
            ->orderBy('bs.date', 'ASC')
            ->first();

        if ($stats_data) {
            $stats['balance'] = $stats_data->balance ?? 0;
            $stats['meals_taken'] = $stats_data->meals_taken ?? 0;
            $stats['next_bazar'] = $stats_data->next_bazar;
        }

        // Fetch balance information
        $balance_info = DB::table('users_table_updated as u')
            ->leftJoin('payments as p', 'p.user_id', '=', 'u.id')
            ->where('u.id', $user_id)
            ->select([
                'u.balance',
                DB::raw('COALESCE(SUM(CASE WHEN p.status = "approved" THEN p.amount ELSE 0 END), 0) as total_paid'),
                DB::raw('COALESCE(SUM(CASE WHEN p.status = "pending" THEN p.amount ELSE 0 END), 0) as pending_payments')
            ])
            ->groupBy('u.id', 'u.balance')
            ->first();

        $current_balance = abs($balance_info->balance ?? 0);

        // Fetch recent meals
        $recent_meals = DB::table('meals as m')
            ->where('m.user_id', $user_id)
            ->where('m.status', 'scheduled')
            ->select([
                'm.id',
                'm.meal_date as date',
                'm.meal_type',
                'm.cost as price',
                'm.rating'
            ])
            ->orderBy('m.meal_date', 'DESC')
            ->limit(5)
            ->get();

        return view('dashboard.user', compact(
            'user_name', 
            'notifications', 
            'stats', 
            'current_balance', 
            'recent_meals'
        ));
    }
}
