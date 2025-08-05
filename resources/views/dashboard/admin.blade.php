<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Meal Manager</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <style>
    .admin-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
    }

    .admin-header h1 {
      margin: 0;
      font-size: 1.8rem;
      color: var(--primary);
    }

    .current-date {
      font-size: 1rem;
      color: var(--dark-primary);
      opacity: 0.8;
    }

    /* Admin Stats Cards */
    .admin-stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .admin-stat-card {
      background: rgba(255, 255, 255, 0.1);
      padding: 1.5rem;
      border-radius: 15px;
      text-align: center;
      transition: transform 0.3s ease;
      border-left: 4px solid var(--accent);
    }

    .admin-stat-card:hover {
      transform: translateY(-5px);
    }

    .admin-stat-value {
      font-size: 2.5rem;
      font-weight: bold;
      color: var(--accent);
      margin-bottom: 0.5rem;
    }

    .admin-stat-label {
      font-size: 0.9rem;
      opacity: 0.8;
      color: var(--dark-primary);
    }

    /* Tables */
    .admin-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }

    .admin-table th {
      background: var(--primary);
      color: white;
      padding: 1rem;
      text-align: left;
      font-weight: 500;
    }

    .admin-table td {
      padding: 1rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .admin-table tr:hover {
      background: rgba(255, 255, 255, 0.1);
    }

    /* Action Buttons */
    .action-btn {
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: 500;
      transition: all 0.3s;
      margin: 0 0.25rem;
    }

    .btn-approve {
      background: #2ecc71;
      color: white;
    }

    .btn-approve:hover {
      background: #27ae60;
    }

    .btn-reject {
      background: #e74c3c;
      color: white;
    }

    .btn-reject:hover {
      background: #c0392b;
    }

    .btn-send {
      background: var(--accent);
      color: var(--dark-primary);
    }

    .btn-send:hover {
      background: #c49344;
    }

    /* Status badges */
    .status-pending {
      background: rgba(255, 165, 0, 0.1);
      color: #ff8c00;
      padding: 0.25rem 0.75rem;
      border-radius: 15px;
      font-size: 0.875rem;
      font-weight: 500;
    }

    .status-approved {
      background: rgba(0, 255, 0, 0.1);
      color: #00b894;
      padding: 0.25rem 0.75rem;
      border-radius: 15px;
      font-size: 0.875rem;
      font-weight: 500;
    }

    /* Form styles */
    .notification-form {
      display: grid;
      gap: 1rem;
      margin-top: 1rem;
    }

    .form-group {
      margin-bottom: 1rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 500;
      color: var(--dark-primary);
    }

    .form-control {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid rgba(255, 255, 255, 0.3);
      border-radius: 5px;
      background: rgba(255, 255, 255, 0.1);
      color: var(--dark-primary);
    }

    .form-control:focus {
      outline: none;
      border-color: var(--accent);
    }

    textarea.form-control {
      resize: vertical;
      min-height: 100px;
    }

    /* Alerts */
    .alert {
      padding: 1rem;
      margin-bottom: 1rem;
      border-radius: 8px;
      font-weight: 500;
    }
    
    .alert-success {
      background: rgba(81, 207, 102, 0.1);
      border: 1px solid #51cf66;
      color: #00b894;
    }
    
    .alert-error {
      background: rgba(255, 107, 107, 0.1);
      border: 1px solid #ff6b6b;
      color: #d63031;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .admin-stats-grid {
        grid-template-columns: 1fr;
      }
      
      .admin-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
      }

      .admin-table {
        font-size: 0.9rem;
      }
      
      .admin-table th, 
      .admin-table td {
        padding: 0.75rem 0.5rem;
      }
    }
  </style>
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="glass-card">
    <div class="nav-container">
      <a href="{{ route('welcome') }}" class="nav-logo">Meal Manager</a>
      <div class="nav-links">
        <a href="{{ route('admin.dashboard') }}" class="active">Admin Dashboard</a>
        <a href="#members">Members</a>
        <a href="#inventory">Inventory</a>
        <a href="#payments">Payments</a>
        <a href="#bazar">Bazar</a>
        <a href="{{ route('logout') }}">Logout</a>
      </div>
    </div>
  </nav>

  <main class="dashboard-container">
    <!-- Admin Header -->
    <header class="admin-header">
      <h1>Admin Dashboard</h1>
      <div class="current-date">{{ date('F j, Y') }}</div>
    </header>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
      <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <!-- Stats Overview -->
    <section class="glass-card">
      <h2 class="section-heading">Dashboard Overview</h2>
      <div class="admin-stats-grid">
        <div class="admin-stat-card">
          <div class="admin-stat-value">{{ $pending_payments }}</div>
          <div class="admin-stat-label">Pending Payments</div>
        </div>
        <div class="admin-stat-card">
          <div class="admin-stat-value">{{ $upcoming_bazar }}</div>
          <div class="admin-stat-label">Upcoming Bazar</div>
        </div>
        <div class="admin-stat-card">
          <div class="admin-stat-value">{{ $inventory_requests }}</div>
          <div class="admin-stat-label">Inventory Requests</div>
        </div>
        <div class="admin-stat-card">
          <div class="admin-stat-value">{{ $active_users }}</div>
          <div class="admin-stat-label">Active Members</div>
        </div>
      </div>
    </section>

    <!-- Pending Payments Section -->
    <section class="glass-card">
      <h2 class="section-heading">Pending Payments</h2>
      <table class="admin-table">
        <thead>
          <tr>
            <th>Member</th>
            <th>Amount</th>
            <th>Payment Method</th>
            <th>Transaction ID</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @if($recent_payments->count() > 0)
            @foreach($recent_payments as $payment)
              <tr>
                <td>{{ $payment->member_name }}</td>
                <td>৳{{ number_format($payment->amount, 2) }}</td>
                <td>{{ ucfirst($payment->payment_method) }}</td>
                <td>{{ $payment->transaction_id ?: 'N/A' }}</td>
                <td>{{ date('M j, Y', strtotime($payment->payment_date)) }}</td>
                <td>
                  <form method="POST" action="{{ route('admin.approve-payment') }}" style="display: inline;">
                    @csrf
                    <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                    <input type="hidden" name="amount" value="{{ $payment->amount }}">
                    <input type="hidden" name="user_id" value="{{ $payment->user_id }}">
                    <button type="submit" class="action-btn btn-approve">Approve</button>
                  </form>
                  <form method="POST" action="{{ route('admin.reject-payment') }}" style="display: inline;">
                    @csrf
                    <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                    <button type="submit" class="action-btn btn-reject">Reject</button>
                  </form>
                </td>
              </tr>
            @endforeach
          @else
            <tr>
              <td colspan="6" style="text-align: center;">No pending payments</td>
            </tr>
          @endif
        </tbody>
      </table>
    </section>

    <!-- Bazar Schedule Section -->
    <section class="glass-card">
      <h2 class="section-heading">Upcoming Bazar Schedule</h2>
      <table class="admin-table">
        <thead>
          <tr>
            <th>Date</th>
            <th>Assigned Member</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @if($bazar_schedule->count() > 0)
            @foreach($bazar_schedule as $schedule)
              <tr>
                <td>{{ date('M j, Y', strtotime($schedule->date)) }}</td>
                <td>{{ $schedule->member_name ?: 'Unassigned' }}</td>
                <td>
                  <span class="status-{{ $schedule->status ?? 'pending' }}">
                    {{ ucfirst($schedule->status ?? 'pending') }}
                  </span>
                </td>
              </tr>
            @endforeach
          @else
            <tr>
              <td colspan="3" style="text-align: center;">No upcoming bazar schedule</td>
            </tr>
          @endif
        </tbody>
      </table>
    </section>

    <!-- Send Notification Section -->
    <section class="glass-card">
      <h2 class="section-heading">Send Notification to All Members</h2>
      <form method="POST" action="{{ route('admin.send-notification') }}" class="notification-form">
        @csrf
        <div class="form-group">
          <label for="title">Title:</label>
          <input type="text" id="title" name="title" class="form-control" required>
        </div>
        
        <div class="form-group">
          <label for="message">Message:</label>
          <textarea id="message" name="message" class="form-control" required></textarea>
        </div>
        
        <div class="form-group">
          <label for="priority">Priority:</label>
          <select id="priority" name="priority" class="form-control" required>
            <option value="info">Info</option>
            <option value="warning">Warning</option>
            <option value="emergency">Emergency</option>
          </select>
        </div>
        
        <button type="submit" class="action-btn btn-send">Send Notification</button>
      </form>
    </section>

    <!-- Inventory Requests Section -->
    @if($inventory_requests_list->count() > 0)
    <section class="glass-card">
      <h2 class="section-heading">Pending Inventory Requests</h2>
      <table class="admin-table">
        <thead>
          <tr>
            <th>Requester</th>
            <th>Item</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Price</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          @foreach($inventory_requests_list as $request)
            <tr>
              <td>{{ $request->requester_name }}</td>
              <td>{{ $request->item_name }}</td>
              <td>{{ $request->quantity }}</td>
              <td>{{ $request->unit_type }}</td>
              <td>৳{{ number_format($request->price, 2) }}</td>
              <td>{{ date('M j, Y', strtotime($request->requested_at)) }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </section>
    @endif
  </main>
</body>
</html>
