@extends('layouts.app')

@section('content')
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #111827 100%);
    color: #e2e8f0;
  }

  .goals-container {
    max-width: 900px;
    margin: 40px auto;
    padding: 10px 15px;
  }

  .card {
    background: rgba(255,255,255,0.08);
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.35);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.15);
  }

  .card-header {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    font-size: 22px;
    color: #61c3e1;
    text-shadow: 0 2px 8px rgba(97,195,225,0.4);
  }

  .form-control {
    border-radius: 14px;
    padding: 10px 14px;
    font-size: 0.95rem;
    border: 1px solid rgba(255,255,255,0.2);
    background: rgba(255,255,255,0.05);
    color: #f1f5f9;
    outline: none;
    backdrop-filter: blur(4px);
  }

  .form-control:focus {
    border-color: #8355c7;
    box-shadow: 0 0 0 4px rgba(131,85,199,0.25);
    background: rgba(255,255,255,0.08);
  }

  .btn-primary, .btn-success, .btn-danger, .btn-secondary {
    border-radius: 14px;
    font-weight: 600;
    transition: all 0.25s ease;
  }

  .btn-primary {
    background: linear-gradient(135deg, #38bdf8, #7c3aed);
    border: none;
    color: #fff;
    box-shadow: 0 6px 18px rgba(56,189,248,0.25);
  }

  .btn-primary:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 10px 24px rgba(56,189,248,0.35);
  }

  .btn-success {
    background: linear-gradient(135deg, #22c55e, #10b981);
    border: none;
    color: #fff;
    box-shadow: 0 6px 18px rgba(34,197,94,0.25);
  }

  .btn-success:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 10px 24px rgba(34,197,94,0.35);
  }

  .btn-danger {
    background: linear-gradient(135deg, #f87171, #b91c1c);
    border: none;
    color: #fff;
    box-shadow: 0 6px 18px rgba(248,113,113,0.25);
  }

  .btn-danger:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 10px 24px rgba(248,113,113,0.35);
  }

  .btn-secondary {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.25);
    color: #f1f5f9;
  }

  .btn-secondary:hover {
    background: rgba(255,255,255,0.25);
    transform: translateY(-2px);
  }

  ul.list-group {
    background: transparent;
  }

  ul.list-group li {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 14px;
    margin-bottom: 10px;
    padding: 12px 18px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
  }

  ul.list-group li p {
    margin-bottom: 0;
  }

  .goal-form input, .goal-form textarea {
    margin-bottom: 10px;
  }

  .goal-form button {
    align-self: start;
  }

  @media (max-width: 768px) {
    ul.list-group li {
      flex-direction: column;
      align-items: flex-start;
    }
    .d-flex.gap-2 {
      flex-direction: column;
      width: 100%;
    }
    .d-flex.gap-2 button {
      width: 100%;
    }
  }
</style>

<div class="goals-container">

    <div class="card shadow-lg mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>My Academic Goals</h4>
            <a href="{{ route('profile') }}" class="btn btn-secondary btn-sm">⬅ Back to Profile</a>
        </div>

        <div class="card-body">

            <!-- Add Goal Form -->
            <form action="{{ route('goals.store') }}" method="POST" class="goal-form d-flex flex-column gap-2 mb-4">
                @csrf
                <input type="text" name="title" class="form-control" placeholder="New Goal" required>
                <textarea name="description" class="form-control" placeholder="Description (optional)"></textarea>
                <input type="date" name="target_date" class="form-control">
                <button type="submit" class="btn btn-primary">Add Goal</button>
            </form>

            <!-- List of Goals -->
            @if($goals->isEmpty())
                <p>No goals set yet.</p>
            @else
                <ul class="list-group">
                    @foreach($goals as $goal)
                        <li class="d-flex justify-content-between align-items-start flex-column flex-md-row">
                            <div class="mb-2 mb-md-0">
                                <strong>{{ $goal->title }}</strong> - {{ $goal->progress }}%
                                @if($goal->target_date)
                                    <br><small>Target: {{ $goal->target_date }}</small>
                                @endif
                                @if($goal->description)
                                    <p class="mb-0">{{ $goal->description }}</p>
                                @endif
                            </div>
                            <div class="d-flex gap-2 mt-2 mt-md-0">

                                <!-- Update Progress -->
                                <form action="{{ route('goals.update', $goal->id) }}" method="POST" class="d-flex gap-2 align-items-center">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="progress" value="{{ $goal->progress }}" min="0" max="100" class="form-control form-control-sm" style="width:80px;">
                                    <button type="submit" class="btn btn-success btn-sm">Update</button>
                                </form>

                                <!-- Delete Goal -->
                                <form action="{{ route('goals.destroy', $goal->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>

                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif

        </div>
    </div>

</div>
@endsection
