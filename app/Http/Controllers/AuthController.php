<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showSignup()
    {
        return view('signup');
    }




    public function signup(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        DB::table('users')->insert([
            'role' => $request->role,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('home')->with('success', 'Signup successful! Please login.');
    }






    public function showLogin()
    {
        return view('login');
    }






    public function login(Request $request)
    {
        $user = DB::table('users')->where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Session::put('user', $user);
            return redirect()->route('profile');
        }

        return back()->with('error', 'Invalid credentials!');
    }






    public function profile()
    {
        if (!Session::has('user')) {
            return redirect()->route('login');
        }
        return view('profile', ['user' => Session::get('user')]);
    }







    public function editProfile()
{
    if (!Session::has('user')) {
        return redirect()->route('login');
    }
    return view('edit-profile', ['user' => Session::get('user')]);
}






public function updateProfile(Request $request)
{
    if (!Session::has('user')) {
        return redirect()->route('login');
    }

    $user = Session::get('user');

    $request->validate([
        'name' => 'required',
        'phone' => 'required',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:6',
    ]);

    $data = [
        'name' => $request->name,
        'phone' => $request->phone,
        'email' => $request->email,
        'updated_at' => now(),
    ];

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    DB::table('users')->where('id', $user->id)->update($data);

    // Refresh session with updated user
    $updatedUser = DB::table('users')->where('id', $user->id)->first();
    Session::put('user', $updatedUser);

    return redirect()->route('profile')->with('success', 'Profile updated successfully!');
}









public function showAvailabilityForm()
{
    $user = Session::get('user');
    if (!$user || $user->role !== 'teacher') {
        return redirect()->route('profile')->with('error', 'Only teachers can create availability.');
    }
    return view('availability-create');
}






public function storeAvailability(Request $request)
{
    $user = Session::get('user');
    if (!$user || $user->role !== 'teacher') {
        return redirect()->route('profile');
    }

    $request->validate([
        'date' => 'required|date',
        'course_name' => 'required|string',
        'duration' => 'required|string',
    ]);

    DB::table('availabilities')->insert([
        'teacher_id' => $user->id,
        'date' => $request->date,
        'course_name' => $request->course_name,
        'duration' => $request->duration,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('profile')->with('success', 'Availability created!');
}









public function removeAvailability($id)
{
    $user = Session::get('user');
    if (!$user || $user->role !== 'teacher') {
        return redirect()->route('profile');
    }

    DB::table('availabilities')->where('id', $id)->where('teacher_id', $user->id)->delete();

    return redirect()->route('profile')->with('success', 'Availability removed!');
}












public function viewTeachers(Request $request)
{
    $user = Session::get('user');
    if (!$user || $user->role !== 'student') {
        return redirect()->route('profile')->with('error', 'Only students can view teachers.');
    }

    $search = $request->query('search');

    // Base query with average rating
    $query = DB::table('users')
        ->where('role', 'teacher')
        ->join('availabilities', 'users.id', '=', 'availabilities.teacher_id')
        ->select(
            'users.name as teacher_name',
            'users.email',
            'users.phone',
            'users.id as teacher_id',
            'availabilities.*',
            DB::raw('(SELECT AVG(rating) FROM history WHERE history.teacher_id = users.id) as average_rating')
        )
        ->orderBy('availabilities.date', 'asc');

    if ($search) {
        $query->where('availabilities.course_name', 'like', "%{$search}%");
    }

    $teachers = $query->get();

    // Top 3 highest-rated teachers
    $topTeachers = $teachers->sortByDesc('average_rating')->take(3);

    return view('teachers-availability', compact('teachers', 'topTeachers', 'search'));
}




















public function addBooking($availability_id)
{
    $student = Session::get('user');
    if (!$student || $student->role !== 'student') {
        return redirect()->route('profile')->with('error', 'Only students can book.');
    }

    // Get the availability
    $availability = DB::table('availabilities')->where('id', $availability_id)->first();
    if (!$availability) {
        return redirect()->back()->with('error', 'Availability not found.');
    }

    // Save booking
    DB::table('bookings')->insert([
        'availability_id' => $availability->id,
        'teacher_id' => $availability->teacher_id,
        'student_id' => $student->id,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Create notifications
    $teacher = DB::table('users')->where('id', $availability->teacher_id)->first();
    $message = "Student {$student->name} booked your course '{$availability->course_name}' on {$availability->date}.";

    // Teacher notification
    DB::table('notifications')->insert([
        'user_id' => $teacher->id,
        'message' => $message,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Student notification
    DB::table('notifications')->insert([
        'user_id' => $student->id,
        'message' => "You booked '{$availability->course_name}' with teacher {$teacher->name} on {$availability->date}.",
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Booking successful!');
}


















public function notifications()
{
    $user = Session::get('user');
    if (!$user) {
        return redirect()->route('login');
    }

    $notifications = DB::table('notifications')
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('notifications', compact('notifications'));
}











public function chatList()
{
    $user = Session::get('user');
    if (!$user) return redirect()->route('login');

    if ($user->role === 'student') {
        // Teachers booked by this student
        $partners = DB::table('bookings')
            ->join('users', 'users.id', '=', 'bookings.teacher_id')
            ->join('availabilities', 'availabilities.id', '=', 'bookings.availability_id')
            ->where('bookings.student_id', $user->id)
            ->select('users.id as user_id', 'users.name', 'availabilities.course_name')
            ->distinct()
            ->get();
    } else {
        // Students who booked this teacher
        $partners = DB::table('bookings')
            ->join('users', 'users.id', '=', 'bookings.student_id')
            ->where('bookings.teacher_id', $user->id)
            ->select('users.id as user_id', 'users.name')
            ->distinct()
            ->get();
    }

    return view('chat-list', compact('partners', 'user'));
}






















public function chatConversation($conversation_id)
{
    $user = Session::get('user');
    if (!$user) return redirect()->route('login');

    $conversation = DB::table('conversations')->where('id', $conversation_id)->first();
    if (!$conversation) return redirect()->route('chat.list')->with('error', 'Conversation not found.');

    $messages = DB::table('messages')->where('conversation_id', $conversation_id)->orderBy('created_at')->get();

    return view('chat-conversation', compact('messages', 'conversation', 'user'));
}












public function sendMessage(Request $request, $conversation_id)
{
    $user = Session::get('user');
    if (!$user) return redirect()->route('login');

    $request->validate([
        'message' => 'required|string',
    ]);

    DB::table('messages')->insert([
        'conversation_id' => $conversation_id,
        'sender_id' => $user->id,
        'message' => $request->message,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->back();
}












public function markDone($booking_id)
{
    $user = Session::get('user');
    if (!$user) return redirect()->route('login');

    $booking = DB::table('bookings')->where('id', $booking_id)->first();
    if (!$booking) return redirect()->back()->with('error', 'Booking not found.');

    // Only teacher or student involved can mark as done
    if ($booking->teacher_id != $user->id && $booking->student_id != $user->id) {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    // Get availability info
    $availability = DB::table('availabilities')->where('id', $booking->availability_id)->first();

    // Insert into history
    DB::table('history')->insert([
        'availability_id' => $booking->availability_id,
        'teacher_id' => $booking->teacher_id,
        'student_id' => $booking->student_id,
        'course_name' => $availability ? $availability->course_name : null,
        'date' => $availability ? $availability->date : null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Delete booking
    DB::table('bookings')->where('id', $booking_id)->delete();

    return redirect()->back()->with('success', 'Marked as Done and moved to History!');
}




















public function history()
{
    $user = Session::get('user');
    if (!$user) return redirect()->route('login');

    if ($user->role === 'student') {
        $records = DB::table('history')
            ->join('users as teachers', 'history.teacher_id', '=', 'teachers.id')
            ->where('history.student_id', $user->id)
            ->select('history.*', 'teachers.name as teacher_name') // include history.*
            ->orderBy('history.date', 'desc')
            ->get();
    } else {
        $records = DB::table('history')
            ->join('users as students', 'history.student_id', '=', 'students.id')
            ->where('history.teacher_id', $user->id)
            ->select('history.*', 'students.name as student_name') // include history.*
            ->orderBy('history.date', 'desc')
            ->get();
    }

    return view('history', compact('records', 'user'));
}






















public function rateTeacher(Request $request, $history_id)
{
    $user = Session::get('user');
    if (!$user || $user->role !== 'student') {
        return redirect()->route('profile')->with('error', 'Unauthorized action.');
    }

    $history = DB::table('history')->where('id', $history_id)->first();
    if (!$history || $history->student_id != $user->id) {
        return redirect()->back()->with('error', 'Record not found.');
    }

    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
    ]);

    DB::table('history')->where('id', $history_id)->update([
        'rating' => $request->rating,
        'updated_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Teacher rated successfully!');
}








}
