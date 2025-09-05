@extends('layouts.app')
@section('title', 'Create Availability')

@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #111827 100%);
    min-height: 100vh;
    color: #f1f5f9;
  }

  .availability-page {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
  }

  .availability-card {
    background: rgba(255, 255, 255, 0.08);
    border-radius: 20px;
    padding: 40px 30px;
    max-width: 500px;
    width: 100%;
    box-shadow: 0 15px 40px rgba(0,0,0,0.35);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.15);
  }

  .availability-card h4 {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    font-weight: 900;
    color: #61c3e1;
    text-align: center;
    margin-bottom: 25px;
    text-shadow: 0 3px 12px rgba(97,195,225,0.4);
  }

  .form-label {
    font-weight: 600;
    color: #e2e8f0;
  }

  .form-control {
    border-radius: 12px;
    padding: 12px 14px;
    font-size: 1rem;
    border: 1px solid rgba(255,255,255,0.2);
    background: rgba(255,255,255,0.05);
    color: #f1f5f9;
    margin-bottom: 18px;
    backdrop-filter: blur(4px);
  }

  .form-control:focus {
    border-color: #8355c7;
    box-shadow: 0 0 0 4px rgba(131,85,199,0.25);
    outline: none;
    background: rgba(255,255,255,0.08);
  }

  .btn-save {
    background: linear-gradient(135deg, #61c3e1, #8355c7, #22c55e);
    color: #fff;
    font-weight: 600;
    padding: 12px;
    border-radius: 12px;
    font-size: 1.05rem;
    border: none;
    box-shadow: 0 10px 25px rgba(97,195,225,0.25);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .btn-save:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 15px 35px rgba(97,195,225,0.35);
  }
</style>

<div class="availability-page">
    <div class="availability-card">
        <h4>Create Availability 📅</h4>

        <form action="{{ route('availability.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Course Name</label>
                <input type="text" name="course_name" class="form-control" placeholder="Enter course title" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Duration</label>
                <input type="text" name="duration" class="form-control" placeholder="e.g., 2 hours" required>
            </div>

            <button type="submit" class="btn-save w-100">Save ✅</button>
        </form>
    </div>
</div>
@endsection
