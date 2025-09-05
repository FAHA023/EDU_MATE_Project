@extends('layouts.app')
@section('title', 'Signup')

@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Playfair+Display:wght@700;900&family=Great+Vibes&display=swap');

  body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #111827 100%);
    color: #f1f5f9;
  }

  .signup-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
  }

  .signup-card {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 20px;
    padding: 40px 30px;
    width: 100%;
    max-width: 520px;
    backdrop-filter: blur(12px);
    box-shadow: 0 20px 60px rgba(0,0,0,0.4);
  }

  .signup-card h4 {
    font-family: 'Playfair Display', serif;
    font-weight: 900;
    font-size: 30px;
    text-align: center;
    margin-bottom: 25px;
    color: #8355c7; /* lavender purple */
    text-shadow: 0 3px 12px rgba(131,85,199,0.4);
  }

  .form-label {
    font-weight: 600;
    color: #e2e8f0;
  }

  .form-control, .form-select {
    border-radius: 10px;
    padding: 12px 14px;
    font-size: 0.95rem;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.2);
    color: #f1f5f9;
  }

  .form-control:focus, .form-select:focus {
    border-color: #61c3e1; /* sky blue focus */
    box-shadow: 0 0 0 4px rgba(97,195,225,0.35);
    outline: none;
  }

  .btn-signup {
    background: linear-gradient(135deg,#61c3e1,#8355c7,#22c55e);
    color: #fff;
    font-weight: 600;
    padding: 12px;
    border-radius: 12px;
    font-size: 1rem;
    border: none;
    box-shadow: 0 8px 20px rgba(131,85,199,0.25);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .btn-signup:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 12px 28px rgba(97,195,225,0.35);
  }
</style>

<div class="signup-page">
  <div class="signup-card">
      <h4>Create Your EDU_MATE Account ✨</h4>

      <form action="{{ route('signup') }}" method="POST">
          @csrf
          <div class="mb-3">
              <label class="form-label">Role</label>
              <select name="role" class="form-select">
                  <option value="teacher">Teacher</option>
                  <option value="student">Student</option>
              </select>
          </div>

          <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" required>
          </div>

          <div class="mb-3">
              <label class="form-label">Phone</label>
              <input type="text" name="phone" class="form-control" required>
          </div>

          <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
          </div>

          <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
          </div>

          <button type="submit" class="btn-signup w-100">Done ✅</button>
      </form>
  </div>
</div>
@endsection
