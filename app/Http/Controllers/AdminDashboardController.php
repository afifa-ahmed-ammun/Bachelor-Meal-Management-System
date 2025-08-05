<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Check if user is logged in and is admin
        if (!session('user_id') || session('role') !== 'admin') {
            return redirect()->route('login');
        }

        // Fetch dashboard statistics
        $pending_payments = DB::table('payments')
            ->where('status', 'pending')
            ->count();

        $upcoming_bazar = DB::table('bazar_schedule')
            ->whereRaw('date >= CURDATE()')
            ->count();

        $inventory_requests = DB::table('inventory_requests')
            ->where('status', 'pending')
            ->count();

        $active_users = DB::table('users_table_updated')
            ->where('role', 'member')
            ->count();

        // Fetch recent pending payments
        $recent_payments = DB::table('payments as p')
            ->join('users_table_updated as u', 'p.user_id', '=', 'u.id')
            ->where('p.status', 'pending')
            ->select([
                'p.*',
                DB::raw('CONCAT(u.first_name, " ", u.last_name) as member_name')
            ])
            ->orderBy('p.payment_date', 'DESC')
            ->get();

        // Fetch upcoming bazar schedule
        $bazar_schedule = DB::table('bazar_schedule as bs')
            ->leftJoin('users_table_updated as u', 'bs.user_id', '=', 'u.id')
            ->select([
                'bs.*',
                DB::raw('CONCAT(u.first_name, " ", u.last_name) as member_name')
            ])
            ->orderBy('bs.date', 'ASC')
            ->limit(5)
            ->get();

        // Fetch pending inventory requests
        $inventory_requests_list = DB::table('inventory_requests as ir')
            ->join('users_table_updated as u', 'ir.user_id', '=', 'u.id')
            ->where('ir.status', 'pending')
            ->select([
                'ir.*',
                DB::raw('CONCAT(u.first_name, " ", u.last_name) as requester_name')
            ])
            ->orderBy('ir.requested_at', 'DESC')
            ->get();

        return view('dashboard.admin', compact(
            'pending_payments',
            'upcoming_bazar', 
            'inventory_requests',
            'active_users',
            'recent_payments',
            'bazar_schedule',
            'inventory_requests_list'
        ));
    }

    public function approvePayment(Request $request)
    {
        if (session('role') !== 'admin') {
            return redirect()->route('login');
        }

        $payment_id = $request->payment_id;
        $amount = $request->amount;
        $user_id = $request->user_id;

        try {
            DB::beginTransaction();

            // Update payment status
            DB::table('payments')
                ->where('id', $payment_id)
                ->update(['status' => 'approved']);

            // Update user balance
            DB::table('users_table_updated')
                ->where('id', $user_id)
                ->update([
                    'balance' => DB::raw('GREATEST(0, balance - ' . $amount . ')')
                ]);

            DB::commit();
            return back()->with('success', 'Payment approved successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error approving payment');
        }
    }

    public function rejectPayment(Request $request)
    {
        if (session('role') !== 'admin') {
            return redirect()->route('login');
        }

        $payment_id = $request->payment_id;

        try {
            DB::table('payments')
                ->where('id', $payment_id)
                ->update(['status' => 'rejected']);

            return back()->with('success', 'Payment rejected');
        } catch (\Exception $e) {
            return back()->with('error', 'Error rejecting payment');
        }
    }

    public function sendNotification(Request $request)
    {
        if (session('role') !== 'admin') {
            return redirect()->route('login');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:info,warning,emergency'
        ]);

        try {
            // Get all members
            $members = DB::table('users_table_updated')
                ->where('role', 'member')
                ->select('id')
                ->get();

            // Insert notification for each member
            foreach ($members as $member) {
                DB::table('notifications')->insert([
                    'user_id' => $member->id,
                    'type' => $request->priority,
                    'title' => $request->title,
                    'message' => $request->message,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            return back()->with('success', 'Notification sent successfully to ' . count($members) . ' members');
        } catch (\Exception $e) {
            return back()->with('error', 'Error sending notification');
        }
    }
}
