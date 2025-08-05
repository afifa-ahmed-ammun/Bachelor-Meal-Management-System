@extends('layouts.app')

@section('title', 'Login - Bachelor Meal System')

@section('content')
<main class="center-container">
    <section class="glass-card centered-form">
        <h2>Login</h2>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 1rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="post">
            @csrf
            
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="{{ route('signup') }}">Signup</a></p>
    </section>
</main>
@endsection
