@extends('layouts.app')
@section('title', 'Home')

@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Playfair+Display:wght@700;900&family=Great+Vibes&display=swap');

  header, nav, .navbar, .site-header { display: none !important; }

  body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #111827 100%);
    color: #f1f5f9;
    min-height: 100vh;
  }

  /* Top-right buttons */
  .edu-top-right {
    position: fixed;
    top: 25px;
    right: 30px;
    display: flex;
    gap: 14px;
    z-index: 1000;
  }
  .edu-top-right a {
    padding: 12px 22px;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    color: white;
    font-size: 1rem;
    backdrop-filter: blur(6px);
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.25);
    transition: all 0.3s ease;
  }
  .edu-top-right a:hover {
    background: rgba(255,255,255,0.25);
    transform: translateY(-3px);
  }

  /* Hero */
  .edu-hero {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 40px 20px;
  }

  .edu-title {
    font-family: 'Playfair Display', serif;
    font-size: 56px;
    font-weight: 900;
    color: #61c3e1ff; /* golden */
    margin-bottom: 20px;
    text-shadow: 0 4px 20px rgba(251,191,36,0.4);
  }

  .edu-tagline {
    font-family: 'Great Vibes', cursive;
    font-size: 40px;  /* bigger */
    font-weight: 600;
    color: #8355c7ff; /* deep purple */
    margin-bottom: 28px;
    text-shadow: 0 3px 16px rgba(76,29,149,0.6); /* highlighted */
  }

  .edu-desc {
    max-width: 800px;
    font-size: 19px;
    line-height: 1.8;
    color: #e2e8f0;
    font-weight: 500;
  }

  @media (max-width: 768px) {
    .edu-title { font-size: 40px; }
    .edu-tagline { font-size: 30px; }
    .edu-desc { font-size: 16px; }
  }
</style>

<!-- Top-right login / signup -->
<div class="edu-top-right">
  <a href="{{ route('login') }}">Login</a>
  <a href="{{ route('signup') }}">Signup</a>
</div>

<!-- Hero section -->
<div class="edu-hero">
  <h1 class="edu-title">Welcome to EDU_MATE</h1>
  <p class="edu-tagline">Where learning meets growth</p>
  <p class="edu-desc">
    This is an online educational platform where students can book tutors, 
    and both can keep track of their studies and goals. EDU_MATE empowers 
    learners and educators to grow together with confidence.
  </p>
</div>
@endsection
