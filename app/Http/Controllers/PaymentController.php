<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Calculate payment summary
        $totalPaid = Payment::where('user_id', $user->id)
            ->where('status', 'paid')
            ->sum('amount');
            
        $pendingPayments = Payment::where('user_id', $user->id)
            ->where('status', 'pending')
            ->sum('amount');
            
        // For now, we'll set meal cost to 0 since we don't have a balance field yet
        $mealCost = 0; // This would come from user's meal consumption
        
        $remaining = $totalPaid - $mealCost;
        
        // Get payment history
        $payments = Payment::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('user.payments', compact(
            'user', 
            'totalPaid', 
            'pendingPayments', 
            'mealCost', 
            'remaining', 
            'payments'
        ));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'method' => 'required|in:cash,bkash,nagad,card',
            'transaction_id' => 'required_if:method,bkash,nagad,card|string|max:100',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            Payment::create([
                'user_id' => Auth::id(),
                'amount' => $request->amount,
                'method' => $request->method,
                'transaction_id' => $request->method === 'cash' ? null : $request->transaction_id,
                'status' => 'pending',
                'date' => now()->toDateString(),
            ]);

            return back()->with('success', 'Payment submitted successfully. Waiting for admin approval.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error processing payment: ' . $e->getMessage());
        }
    }
}
