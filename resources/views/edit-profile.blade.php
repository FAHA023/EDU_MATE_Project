@extends('layouts.app')
@section('title', 'Edit Profile')

@section('content')
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #111827 100%);
    color: #27394bff;
  }

  .edit-profile-container {
    max-width: 600px;
    margin: 40px auto;
    padding: 20px;
  }

  .edit-card {
    background: rgba(255,255,255,0.08);
    border-radius: 20px;
    padding: 30px 25px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.35);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.15);
  }

  .edit-card h4 {
    font-family: 'Playfair Display', serif;
    font-weight: 900;
    font-size: 26px;
    color: #61c3e1;
    margin-bottom: 25px;
    text-align: center;
    text-shadow: 0 3px 12px rgba(97,195,225,0.4);
  }

  .form-label {
    font-weight: 600;
    color: #e2e8f0;
  }

  .form-control {
    border-radius: 14px;
    padding: 12px 16px;
    font-size: 1rem;
    border: 1px solid rgba(255,255,255,0.2);
    background: rgba(255,255,255,0.05);
    color: #f1f5f9;
    margin-bottom: 15px;
    outline: none;
    backdrop-filter: blur(4px);
  }

  .form-control:focus {
    border-color: #8355c7;
    box-shadow: 0 0 0 4px rgba(131,85,199,0.25);
    background: rgba(255,255,255,0.08);
  }

  /* Darker role input for readability */
  .form-control[disabled] {
    background: rgba(131,85,199,0.3); /* dark purple shade */
    color: #f1f5f9; /* readable text */
    border: 1px solid rgba(131,85,199,0.5);
    cursor: not-allowed;
  }

  .btn-submit {
    background: linear-gradient(135deg, #22c55e, #10b981);
    color: #b5e984ff;
    font-weight: 600;
    padding: 12px;
    border-radius: 14px;
    font-size: 1rem;
    border: none;
    box-shadow: 0 10px 25px rgba(34,197,94,0.35);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .btn-submit:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 14px 30px rgba(34,197,94,0.45);
  }

  .back-btn {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 18px;
    border-radius: 12px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.25);
    color: #2d343bff;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.25s ease;
  }

  .back-btn:hover {
    background: rgba(255,255,255,0.25);
    transform: translateY(-2px);
  }
</style>

<div class="edit-profile-container">
    <div class="edit-card">
        <h4>Edit Profile ✏️</h4>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Role (cannot be changed)</label>
                <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" value="{{ $user->phone }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password (leave blank if not changing)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <button type="submit" class="btn-submit w-100">Done ✅</button>
        </form>
    </div>

    <a href="{{ route('history') }}" class="back-btn">History 📜</a>
</div>
@endsection
