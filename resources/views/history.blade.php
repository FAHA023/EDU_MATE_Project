@extends('layouts.app')
@section('title', 'History')

@section('content')
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #111827 100%);
    color: #f1f5f9;
  }

  .history-container {
    max-width: 800px;
    margin: 40px auto;
    padding: 20px;
  }

  .history-title {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    font-weight: 900;
    color: #61c3e1;
    text-align: center;
    margin-bottom: 30px;
    text-shadow: 0 3px 12px rgba(97,195,225,0.4);
  }

  .history-card {
    background: rgba(255,255,255,0.08);
    border-radius: 18px;
    padding: 18px 20px;
    margin-bottom: 18px;
    box-shadow: 0 8px 28px rgba(0,0,0,0.25);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.15);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
  }

  .history-info {
    font-size: 16px;
    color: #e2e8f0;
    margin-bottom: 10px;
  }

  .history-rating select {
    border-radius: 10px;
    padding: 4px 8px;
    font-size: 0.9rem;
    border: 1px solid rgba(255,255,255,0.3);
    background: rgba(255,255,255,0.05);
    color: #f1f5f9;
    margin-right: 6px;
    outline: none;
  }

  .history-rating select:focus {
    border-color: #8355c7;
    box-shadow: 0 0 0 3px rgba(131,85,199,0.25);
    background: rgba(255,255,255,0.08);
  }

  .btn-rate {
    background: linear-gradient(135deg, #22c55e, #10b981);
    color: #fff;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 10px;
    border: none;
    font-size: 0.9rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .btn-rate:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 10px 20px rgba(34,197,94,0.35);
  }

  .badge-rated {
    background: linear-gradient(135deg, #38bdf8, #7c3aed);
    color: #fff;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 12px;
    font-size: 0.9rem;
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
    .history-card {
      flex-direction: column;
      align-items: flex-start;
    }
    .history-rating {
      margin-top: 10px;
    }
  }
</style>

<div class="history-container">
    <h4 class="history-title">History 📜</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($records->isEmpty())
        <p>No completed sessions yet.</p>
    @else
        @foreach($records as $r)
            <div class="history-card">
                <div class="history-info">
                    @if($user->role === 'student')
                        Teacher: <strong>{{ $r->teacher_name }}</strong> | Course: {{ $r->course_name }} | Date: {{ $r->date }}
                    @else
                        Student: <strong>{{ $r->student_name }}</strong> | Course: {{ $r->course_name }} | Date: {{ $r->date }}
                    @endif
                </div>

                <div class="history-rating">
                    @if($user->role === 'student' && !$r->rating)
                        <form action="{{ route('history.rate', $r->id) }}" method="POST" class="d-flex align-items-center">
                            @csrf
                            <select name="rating" required>
                                <option value="">Rate</option>
                                <option value="1">1 ⭐</option>
                                <option value="2">2 ⭐</option>
                                <option value="3">3 ⭐</option>
                                <option value="4">4 ⭐</option>
                                <option value="5">5 ⭐</option>
                            </select>
                            <button class="btn-rate">Done ✅</button>
                        </form>
                    @elseif(isset($r->rating))
                        <span class="badge-rated">{{ $r->rating }} ⭐</span>
                    @endif
                </div>
            </div>
        @endforeach
    @endif

    <a href="{{ route('profile') }}" class="back-btn">⬅ Back to Profile</a>
</div>
@endsection
