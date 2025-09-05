@extends('layouts.app')
@section('title', 'Chat List')

@section('content')
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #111827 100%);
    color: #f1f5f9;
  }

  .chatlist-container {
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
    margin-bottom: 25px;
    text-shadow: 0 3px 12px rgba(97,195,225,0.4);
  }

  .chatlist-card {
    background: rgba(255,255,255,0.08);
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.35);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.15);
  }

  .chat-partner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgba(255,255,255,0.05);
    padding: 12px 16px;
    margin-bottom: 12px;
    border-radius: 14px;
    transition: background 0.25s ease;
  }

  .chat-partner:hover {
    background: rgba(97,195,225,0.1);
  }

  .chat-partner .btn {
    margin-left: 6px;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.25s ease;
  }

  .btn-chat {
    background: linear-gradient(135deg, #61c3e1, #8355c7);
    color: #fff;
    border: none;
  }

  .btn-chat:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 10px 25px rgba(97,195,225,0.35);
  }

  .btn-done {
    background: linear-gradient(135deg, #22c55e, #10b981);
    color: #fff;
    border: none;
  }

  .btn-done:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 10px 25px rgba(34,197,94,0.35);
  }

  .back-btn {
    display: inline-block;
    margin-top: 20px;
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

<div class="chatlist-container">
    <h4>Chat Partners 💬</h4>

    <div class="chatlist-card">
        @if($partners->isEmpty())
            <p class="text-center">No chat partners yet.</p>
        @else
            @foreach($partners as $p)
                @php
                    $conv = DB::table('conversations')
                        ->where(function($q) use ($user, $p){
                            $q->where('user1', $user->id)->where('user2', $p->user_id);
                        })
                        ->orWhere(function($q) use ($user, $p){
                            $q->where('user1', $p->user_id)->where('user2', $user->id);
                        })->first();

                    $booking = DB::table('bookings')
                        ->where('teacher_id', $user->role == 'teacher' ? $user->id : $p->user_id)
                        ->where('student_id', $user->role == 'student' ? $user->id : $p->user_id)
                        ->first();
                @endphp

                <div class="chat-partner">
                    <div>
                        {{ $p->name }}
                        @if(isset($p->course_name))
                            - {{ $p->course_name }}
                        @endif
                    </div>
                    <div>
                        @if($conv)
                            <a href="{{ route('chat.conversation', $conv->id) }}" class="btn btn-chat btn-sm">Chat 💬</a>
                        @else
                            @php
                                $new_conv_id = DB::table('conversations')->insertGetId([
                                    'user1' => $user->id,
                                    'user2' => $p->user_id,
                                    'created_at' => now(),
                                    'updated_at' => now()
                                ]);
                            @endphp
                            <a href="{{ route('chat.conversation', $new_conv_id) }}" class="btn btn-chat btn-sm">Chat 💬</a>
                        @endif

                        @if($booking)
                            <form action="{{ route('chat.done', $booking->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-done btn-sm">Done ✅</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <a href="{{ route('profile') }}" class="back-btn">⬅ Back to Profile</a>
</div>
@endsection
