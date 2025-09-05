@extends('layouts.app')
@section('title', 'Chat')

@section('content')
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #111827 100%);
    color: #f1f5f9;
  }

  .chat-container {
    max-width: 800px;
    margin: 40px auto;
    padding: 20px;
  }

  h4 {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    font-weight: 900;
    color: #61c3e1;
    text-align: center;
    margin-bottom: 20px;
    text-shadow: 0 3px 12px rgba(97,195,225,0.4);
  }

  .chat-card {
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 20px;
    padding: 20px;
    height: 400px;
    overflow-y: auto;
    box-shadow: 0 12px 40px rgba(0,0,0,0.35);
    backdrop-filter: blur(12px);
    margin-bottom: 20px;
  }

  .message {
    display: inline-block;
    max-width: 75%;
    padding: 12px 16px;
    border-radius: 20px;
    margin-bottom: 10px;
    font-size: 0.95rem;
    line-height: 1.4;
    word-wrap: break-word;
  }

  .message.sent {
    background: linear-gradient(135deg, #22c55e, #10b981);
    color: white;
    margin-left: auto;
    text-align: right;
  }

  .message.received {
    background: linear-gradient(135deg, #61c3e1, #8355c7);
    color: white;
    margin-right: auto;
    text-align: left;
  }

  .message small {
    display: block;
    font-size: 0.7rem;
    color: rgba(255,255,255,0.7);
    margin-top: 4px;
  }

  .chat-form {
    display: flex;
    gap: 10px;
  }

  .chat-form input[type="text"] {
    flex: 1;
    padding: 12px 16px;
    border-radius: 14px;
    border: 1px solid rgba(255,255,255,0.2);
    background: rgba(255,255,255,0.05);
    color: #f1f5f9;
    font-size: 1rem;
    outline: none;
    backdrop-filter: blur(4px);
  }

  .chat-form input[type="text"]:focus {
    border-color: #8355c7;
    box-shadow: 0 0 0 4px rgba(131,85,199,0.25);
    background: rgba(255,255,255,0.08);
  }

  .chat-form button {
    background: linear-gradient(135deg, #61c3e1, #8355c7);
    color: #fff;
    font-weight: 600;
    padding: 12px 20px;
    border-radius: 14px;
    border: none;
    box-shadow: 0 8px 20px rgba(97,195,225,0.25);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .chat-form button:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 12px 28px rgba(131,85,199,0.35);
  }

  .back-btn {
    display: inline-block;
    margin-top: 15px;
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
</style>

<div class="chat-container">
    <h4>Chat 💬</h4>

    <div class="chat-card">
        @foreach($messages as $msg)
            <div class="message {{ $msg->sender_id == $user->id ? 'sent' : 'received' }}">
                {{ $msg->message }}
                <small>{{ $msg->created_at }}</small>
            </div>
        @endforeach
    </div>

    <form action="{{ route('chat.send', $conversation->id) }}" method="POST" class="chat-form">
        @csrf
        <input type="text" name="message" placeholder="Type a message..." required>
        <button type="submit">Send ➤</button>
    </form>

    <a href="{{ route('chat.list') }}" class="back-btn">⬅ Back to Chats</a>
</div>
@endsection
