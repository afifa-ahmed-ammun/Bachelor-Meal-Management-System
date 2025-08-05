@extends('layouts.app')

@section('title', 'Signup - Bachelor Meal System')

@section('content')
<main class="center-container">
    <section class="glass-card centered-form">
        <h2>Signup</h2>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 1rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('signup') }}" method="post">
            @csrf
            
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required>

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>

            <label for="phone">Phone Number:</label>
            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required>

            <label for="apartment">Apartment Name:</label>
            <input type="text" name="apartment" id="apartment" value="{{ old('apartment') }}" required>

            <label for="role">Role:</label>
            <select name="role" id="role" required>
                <option value="" disabled selected>Select your role</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member</option>
            </select>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>

            <button type="submit">Signup</button>
        </form>
        <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
    </section>
</main>
@endsection
