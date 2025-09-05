@extends('layouts.app')
@section('title', 'Notifications')

@section('content')
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #111827 100%);
    color: #f1f5f9;
  }

  .notifications-container {
    max-width: 800px;
    margin: 40px auto;
    padding: 20px;
  }

  .notifications-title {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    font-weight: 900;
    color: #61c3e1;
    text-align: center;
    margin-bottom: 30px;
    text-shadow: 0 3px 12px rgba(97,195,225,0.4);
  }

  .notification-card {
    background: rgba(255,255,255,0.08);
    border-radius: 18px;
    padding: 15px 20px;
    margin-bottom: 15px;
    box-shadow: 0 8px 28px rgba(0,0,0,0.25);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.15);
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .notification-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.35);
  }

  .notification-text {
    font-size: 16px;
    color: #e2e8f0;
  }

  .notification-unread {
    font-weight: 600;
    background: linear-gradient(135deg, #38bdf8, #7c3aed);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  .notification-time {
    font-size: 0.85rem;
    color: #94a3b8;
  }

  .back-btn {
    display: inline-block;
    margin-top: 25px;
    padding: 10px 18px;
    border-radius: 12px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.25);
    color: #f1f5f9;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.25s ease;
  }

  .back-btn:hover {
    background: rgba(255,255,255,0.25);
    transform: translateY(-2px);
  }

  @media (max-width: 576px) {
    .notification-card {
      flex-direction: column;
      align-items: flex-start;
    }
    .notification-time {
      margin-top: 6px;
    }
  }
</style>

<div class="notifications-container">
    <h4 class="notifications-title">Notifications 🔔</h4>

    @if($notifications->isEmpty())
        <p>No notifications yet.</p>
    @else
        @foreach($notifications as $n)
            <div class="notification-card">
                <div class="notification-text {{ $n->read ? '' : 'notification-unread' }}">
                    {{ $n->message }}
                </div>
                <div class="notification-time">{{ $n->created_at }}</div>
            </div>
        @endforeach
    @endif

    <a href="{{ route('profile') }}" class="back-btn">⬅ Back to Profile</a>
</div>
@endsection
