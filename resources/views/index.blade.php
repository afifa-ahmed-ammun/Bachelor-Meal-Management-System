@extends('layouts.app')

@section('title', 'Bachelor Meal Management System')

@section('content')
<!-- Hero Section -->
<section class="glass-card hero-section">
    <div class="hero-content">
        <h1>Bachelor Meal Management System</h1>
        <p class="hero-subtitle">Simplify your shared apartment life with our all-in-one meal management solution</p>
        <div class="hero-buttons">
            <a href="{{ route('login') }}" class="button">Login</a>
            <a href="{{ route('signup') }}" class="button">Signup</a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="glass-card" id="features">
    <h2 class="section-heading">Key Features</h2>
    <div class="features-list">
        <div class="feature-item">
            <h3>Meal Management</h3>
            <p>Track daily meals, schedule cooking, and manage responsibilities.</p>
        </div>
        <div class="feature-item">
            <h3>Bazar Rotation</h3>
            <p>Automated grocery shopping rotation and tracking.</p>
        </div>
        <div class="feature-item">
            <h3>Payment System</h3>
            <p>Shared payments with admin approval and tracking.</p>
        </div>
        <div class="feature-item">
            <h3>Meal Ratings</h3>
            <p>Rate meals and provide feedback to improve quality.</p>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="glass-card" id="about">
    <h2 class="section-heading">About Our System</h2>
    <div class="about-content">
        <p>Designed specifically for bachelor shared apartments, our system helps manage all aspects of communal living with a focus on meal management. Say goodbye to arguments about who should cook or shop next!</p>
        <p>Our platform is secure, easy to use, and accessible from any device.</p>
    </div>
</section>
@endsection
