@extends('layouts.app')

@section('title', 'Payments - Bachelor Meal System')

@section('content')
<main class="glass-card">
    <header style="text-align: center; margin-bottom: 2rem;">
        <h1 style="color: var(--primary); margin-bottom: 1rem;">Payment Management</h1>
        <p>View your payment status, make new payments, and track payment history</p>
    </header>

    <!-- Summary Cards -->
    <section style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="content-section" style="text-align: center;">
            <h3>Total Meal Cost</h3>
            <div style="font-size: 2rem; font-weight: bold; color: var(--error); margin: 0.5rem 0;">
                ৳{{ number_format($mealCost, 2) }}
            </div>
            <p>Total cost of meals</p>
        </div>
        <div class="content-section" style="text-align: center;">
            <h3>Total Paid</h3>
            <div style="font-size: 2rem; font-weight: bold; color: var(--success); margin: 0.5rem 0;">
                ৳{{ number_format($totalPaid, 2) }}
            </div>
            <p>Approved payments</p>
        </div>
        <div class="content-section" style="text-align: center;">
            <h3>Pending Payments</h3>
            <div style="font-size: 2rem; font-weight: bold; color: var(--warning); margin: 0.5rem 0;">
                ৳{{ number_format($pendingPayments, 2) }}
            </div>
            <p>Awaiting approval</p>
        </div>
        <div class="content-section" style="text-align: center;">
            <h3>Balance</h3>
            <div style="font-size: 2rem; font-weight: bold; color: {{ $remaining < 0 ? 'var(--error)' : 'var(--success)' }}; margin: 0.5rem 0;">
                ৳{{ number_format(abs($remaining), 2) }}
            </div>
            <p>{{ $remaining < 0 ? 'Amount due' : 'Credit balance' }}</p>
        </div>
    </section>

    <!-- Payment Form -->
    <section class="content-section">
        <h2>Make a Payment</h2>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 1rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.payments.store') }}" method="POST" id="paymentForm">
            @csrf
            
            <div style="margin-bottom: 1.5rem;">
                <label for="amount" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Payment Amount (৳)</label>
                <input type="number" id="amount" name="amount" 
                       style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: 5px; font-size: 1rem;" 
                       min="1" step="0.01" value="{{ old('amount') }}" required>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Payment Method</label>
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 120px;">
                        <input type="radio" id="cash" name="method" value="cash" {{ old('method', 'cash') == 'cash' ? 'checked' : '' }} style="display: none;">
                        <label for="cash" style="display: block; padding: 0.75rem; border: 1px solid var(--border); border-radius: 5px; text-align: center; cursor: pointer; transition: all 0.3s;" onclick="toggleTransactionId()">Cash</label>
                    </div>
                    <div style="flex: 1; min-width: 120px;">
                        <input type="radio" id="bkash" name="method" value="bkash" {{ old('method') == 'bkash' ? 'checked' : '' }} style="display: none;">
                        <label for="bkash" style="display: block; padding: 0.75rem; border: 1px solid var(--border); border-radius: 5px; text-align: center; cursor: pointer; transition: all 0.3s;" onclick="toggleTransactionId()">bKash</label>
                    </div>
                    <div style="flex: 1; min-width: 120px;">
                        <input type="radio" id="nagad" name="method" value="nagad" {{ old('method') == 'nagad' ? 'checked' : '' }} style="display: none;">
                        <label for="nagad" style="display: block; padding: 0.75rem; border: 1px solid var(--border); border-radius: 5px; text-align: center; cursor: pointer; transition: all 0.3s;" onclick="toggleTransactionId()">Nagad</label>
                    </div>
                    <div style="flex: 1; min-width: 120px;">
                        <input type="radio" id="card" name="method" value="card" {{ old('method') == 'card' ? 'checked' : '' }} style="display: none;">
                        <label for="card" style="display: block; padding: 0.75rem; border: 1px solid var(--border); border-radius: 5px; text-align: center; cursor: pointer; transition: all 0.3s;" onclick="toggleTransactionId()">Card</label>
                    </div>
                </div>
            </div>

            <div id="transactionIdGroup" style="margin-bottom: 1.5rem; display: {{ old('method') && old('method') != 'cash' ? 'block' : 'none' }};">
                <label for="transaction_id" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Transaction ID</label>
                <input type="text" id="transaction_id" name="transaction_id" 
                       style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: 5px; font-size: 1rem;" 
                       placeholder="Enter transaction ID" value="{{ old('transaction_id') }}">
            </div>

            <button type="submit" class="button" style="width: 100%; background-color: var(--primary); color: white; border: none; padding: 0.75rem; border-radius: 5px; font-size: 1rem; cursor: pointer;">
                Submit Payment
            </button>
        </form>
    </section>

    <!-- Payment History -->
    <section class="content-section" style="margin-top: 2rem;">
        <h2>Payment History</h2>
        @if($payments->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
                    <thead>
                        <tr style="background-color: var(--primary); color: white;">
                            <th style="padding: 1rem; text-align: left; border-radius: 0.5rem 0 0 0;">Date</th>
                            <th style="padding: 1rem; text-align: left;">Amount</th>
                            <th style="padding: 1rem; text-align: left;">Method</th>
                            <th style="padding: 1rem; text-align: left;">Transaction ID</th>
                            <th style="padding: 1rem; text-align: left; border-radius: 0 0.5rem 0 0;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr style="border-bottom: 1px solid rgba(0, 0, 0, 0.1);">
                                <td style="padding: 1rem;">{{ $payment->date ? $payment->date->format('M j, Y') : $payment->created_at->format('M j, Y') }}</td>
                                <td style="padding: 1rem; font-family: monospace; font-weight: 500;">৳{{ number_format($payment->amount, 2) }}</td>
                                <td style="padding: 1rem;">{{ ucfirst($payment->method) }}</td>
                                <td style="padding: 1rem;">{{ $payment->transaction_id ?: 'N/A' }}</td>
                                <td style="padding: 1rem;">
                                    <span style="padding: 0.4rem 0.8rem; border-radius: 2rem; font-size: 0.875rem; font-weight: 500; 
                                        {{ $payment->status == 'paid' ? 'background: rgba(46, 204, 113, 0.2); color: #2ecc71; border: 1px solid rgba(46, 204, 113, 0.3);' : 
                                           ($payment->status == 'pending' ? 'background: rgba(243, 156, 18, 0.2); color: #f39c12; border: 1px solid rgba(243, 156, 18, 0.3);' : 
                                           'background: rgba(231, 76, 60, 0.2); color: #e74c3c; border: 1px solid rgba(231, 76, 60, 0.3);') }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>No payment history found.</p>
        @endif
    </section>
</main>

<script>
function toggleTransactionId() {
    const selectedMethod = document.querySelector('input[name="method"]:checked');
    const transactionIdGroup = document.getElementById('transactionIdGroup');
    const transactionIdInput = document.getElementById('transaction_id');
    
    // Update label styles
    document.querySelectorAll('input[name="method"] + label').forEach(label => {
        label.style.borderColor = 'var(--border)';
        label.style.backgroundColor = 'transparent';
    });
    
    if (selectedMethod) {
        selectedMethod.nextElementSibling.style.borderColor = 'var(--primary)';
        selectedMethod.nextElementSibling.style.backgroundColor = 'rgba(46, 204, 113, 0.1)';
        
        if (selectedMethod.value === 'cash') {
            transactionIdGroup.style.display = 'none';
            transactionIdInput.required = false;
        } else {
            transactionIdGroup.style.display = 'block';
            transactionIdInput.required = true;
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleTransactionId();
    
    // Add event listeners to all radio buttons
    document.querySelectorAll('input[name="method"]').forEach(radio => {
        radio.addEventListener('change', toggleTransactionId);
    });
});
</script>
@endsection
