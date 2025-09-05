@extends('layouts.app')
@section('title', 'Profile')

@section('content')
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #111827 100%);
    color: #f1f5f9;
    margin: 0;
  }

  .profile-container {
    max-width: 1100px;
    margin: 40px auto;
    padding: 20px;
  }

  /* Profile Card */
  .profile-card {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 40px;
    backdrop-filter: blur(12px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.4);
    text-align: center;
  }

  .profile-card h2 {
    font-family: 'Playfair Display', serif;
    font-size: 32px;
    font-weight: 900;
    color: #61c3e1;
    margin-bottom: 10px;
    text-shadow: 0 3px 12px rgba(97,195,225,0.4);
  }

  .profile-card p {
    font-size: 16px;
    margin: 5px 0;
    color: #e2e8f0;
  }

  /* Features Grid */
  .features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 25px;
  }

  .feature-box {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 30px 20px;
    text-align: center;
    font-weight: 600;
    font-size: 1rem;
    color: #f1f5f9;
    text-decoration: none;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    border: 1px solid rgba(255,255,255,0.2);
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
  }

  .feature-box:hover {
    transform: translateY(-6px) scale(1.03);
    box-shadow: 0 15px 35px rgba(0,0,0,0.45);
  }

  .feature-box h5 {
    font-size: 20px;
    font-weight: 700;
    color: #8355c7;
    margin-bottom: 15px;
  }

  .feature-box a {
    display: block;
    padding: 12px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    color: #fff;
    background: linear-gradient(135deg,#61c3e1,#8355c7,#22c55e);
    box-shadow: 0 6px 16px rgba(97,195,225,0.25);
    transition: all 0.25s ease;
  }

  .feature-box a:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 24px rgba(131,85,199,0.35);
  }

  /* Scrollable if many features */
  .features-grid {
    max-height: 600px;
    overflow-y: auto;
    padding-right: 8px;
  }

  .features-grid::-webkit-scrollbar {
    width: 8px;
  }

  .features-grid::-webkit-scrollbar-thumb {
    background: rgba(131,85,199,0.5);
    border-radius: 6px;
  }
</style>

<div class="profile-container">
    <!-- Profile Info Card -->
    <div class="profile-card">
        <h2>{{ $user->name }}</h2>
        <p><strong>{{ ucfirst($user->role) }}</strong></p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Phone:</strong> {{ $user->phone }}</p>
    </div>

    <!-- Features Grid -->
    <div class="features-grid">
        <div class="feature-box">
            <h5>Edit Profile</h5>
            <a href="{{ route('profile.edit') }}">Go ✏️</a>
        </div>
        <div class="feature-box">
            <h5>Notifications</h5>
            <a href="{{ route('notifications') }}">Open 🔔</a>
        </div>
        <div class="feature-box">
            <h5>Chat</h5>
            <a href="{{ route('chat.list') }}">Start 💬</a>
        </div>
        <div class="feature-box">
            <h5>History</h5>
            <a href="{{ route('history') }}">View 📜</a>
        </div>
        <div class="feature-box">
            <h5>Goal Tracker</h5>
            <a href="{{ route('goals.index') }}">Track 🎯</a>
        </div>
        <div class="feature-box">
            <h5>Logout</h5>
            <a href="{{ route('home') }}">Logout ⬅</a>
        </div>

        @if($user->role === 'teacher')
        <div class="feature-box">
            <h5>Availabilities</h5>
            <a href="{{ route('availability.create') }}">Create 📅</a>
        </div>
        @endif

        @if($user->role === 'student')
        <div class="feature-box">
            <h5>Teachers</h5>
            <a href="{{ route('teachers.view') }}">View 👨‍🏫</a>
        </div>
        @endif
    </div>
</div>
@endsection
