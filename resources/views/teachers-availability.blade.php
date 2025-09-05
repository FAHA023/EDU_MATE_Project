@extends('layouts.app')

@section('title', 'Available Teachers')

@section('content')
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #111827 100%);
    color: #f1f5f9;
  }

  .teachers-container {
    max-width: 1000px;
    margin: 40px auto;
    padding: 20px;
  }

  .teachers-title {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    font-weight: 900;
    color: #61c3e1;
    text-align: center;
    margin-bottom: 30px;
    text-shadow: 0 3px 12px rgba(97,195,225,0.4);
  }

  .search-bar input {
    border-radius: 10px 0 0 10px;
    padding: 10px;
    border: 1px solid #cbd5e1;
    flex: 1;
  }
  .search-bar button {
    border-radius: 0 10px 10px 0;
    padding: 10px 18px;
    background: linear-gradient(135deg,#38bdf8,#7c3aed);
    color: white;
    border: none;
    font-weight: 600;
    transition: all 0.25s ease;
  }
  .search-bar button:hover {
    transform: translateY(-2px);
  }

  .top-teacher-card {
    background: rgba(255,255,255,0.08);
    border-radius: 18px;
    padding: 15px 20px;
    margin-bottom: 15px;
    box-shadow: 0 8px 28px rgba(0,0,0,0.25);
    backdrop-filter: blur(10px);
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .top-teacher-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.35);
  }

  .top-teacher-name {
    font-weight: 600;
    font-size: 16px;
    color: #e2e8f0;
  }
  .top-teacher-rating {
    background: linear-gradient(135deg,#38bdf8,#7c3aed);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: 700;
  }

  .btn-add {
    border-radius: 10px;
    background: linear-gradient(135deg,#10b981,#059669);
    color: white;
    font-weight: 600;
    transition: transform 0.2s ease;
  }
  .btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(5,150,105,0.24);
  }

  table {
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    overflow: hidden;
  }
  th, td {
    color: #e2e8f0;
    vertical-align: middle !important;
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

  @media (max-width: 768px) {
    .top-teacher-card { flex-direction: column; align-items: flex-start; }
  }
</style>

<div class="teachers-container">
    <h4 class="teachers-title">Available Teachers 👨‍🏫</h4>

    <!-- Search Bar -->
    <div class="row mb-3">
        <div class="col-md-6">
            <form method="GET" action="{{ route('teachers.view') }}" class="d-flex search-bar">
                <input type="text" name="search" class="form-control" placeholder="Search by course name" value="{{ $search ?? '' }}">
                <button class="btn">Search 🔍</button>
            </form>
        </div>
    </div>

    <!-- Top 3 Rated Teachers -->
    @if($topTeachers->isNotEmpty())
        <h5>🌟 Top 3 Rated Teachers</h5>
        @foreach($topTeachers as $t)
            <div class="top-teacher-card">
                <div class="top-teacher-name">
                    <strong>{{ $t->teacher_name }}</strong> | Course: {{ $t->course_name }} | Date: {{ $t->date }} | 
                    Rating: <span class="top-teacher-rating">
                        @if($t->average_rating) {{ number_format($t->average_rating, 1) }} ⭐ @else No rating @endif
                    </span>
                </div>
                <form action="{{ route('booking.add', $t->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-add btn-sm">Add ✅</button>
                </form>
            </div>
        @endforeach
    @endif

    <!-- All Teachers Table -->
    @if($teachers->isEmpty())
        <p>No teachers have created availabilities yet.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped mt-3">
                <thead>
                    <tr>
                        <th>Teacher</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Course</th>
                        <th>Date</th>
                        <th>Duration</th>
                        <th>Rating</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $t)
                        <tr>
                            <td>{{ $t->teacher_name }}</td>
                            <td>{{ $t->email }}</td>
                            <td>{{ $t->phone }}</td>
                            <td>{{ $t->course_name }}</td>
                            <td>{{ $t->date }}</td>
                            <td>{{ $t->duration }}</td>
                            <td>
                                @if($t->average_rating) {{ number_format($t->average_rating, 1) }} ⭐ @else No rating @endif
                            </td>
                            <td>
                                <form action="{{ route('booking.add', $t->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-add btn-sm">Add ✅</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <a href="{{ route('profile') }}" class="back-btn">⬅ Back to Profile</a>
</div>
@endsection
