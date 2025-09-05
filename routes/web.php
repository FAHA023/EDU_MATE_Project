<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoalController;


Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/profile', [AuthController::class, 'profile'])->name('profile');


// edit profile
Route::get('/profile/edit', [AuthController::class, 'editProfile'])->name('profile.edit');
Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');


//teacher avaiability--------
//create avaiability
Route::get('/availability/create', [AuthController::class, 'showAvailabilityForm'])->name('availability.create');
//store it to the database
Route::post('/availability/store', [AuthController::class, 'storeAvailability'])->name('availability.store');
//remove it from the database
Route::post('/availability/remove/{id}', [AuthController::class, 'removeAvailability'])->name('availability.remove');


//takes student to the view available teacher page
Route::get('/teachers/availabilities', [AuthController::class, 'viewTeachers'])->name('teachers.view');


//pressing the add button on the view available teacher page
Route::post('/bookings/add/{availability_id}', [AuthController::class, 'addBooking'])->name('booking.add');
//sending notification to teacher and student 
Route::get('/notifications', [AuthController::class, 'notifications'])->name('notifications');


// Show list of chat partners
Route::get('/chat', [AuthController::class, 'chatList'])->name('chat.list');

// Open chat with specific user
Route::get('/chat/{conversation_id}', [AuthController::class, 'chatConversation'])->name('chat.conversation');
Route::post('/chat/send/{conversation_id}', [AuthController::class, 'sendMessage'])->name('chat.send');


// Mark chat/booking as Done
Route::post('/chat/done/{booking_id}', [AuthController::class, 'markDone'])->name('chat.done');

// View history
Route::get('/history', [AuthController::class, 'history'])->name('history');


//rating 
Route::post('/history/rate/{history_id}', [AuthController::class, 'rateTeacher'])->name('history.rate');



//goal
Route::get('/goals', [GoalController::class, 'index'])->name('goals.index');
Route::post('/goals', [GoalController::class, 'store'])->name('goals.store');
Route::patch('/goals/{goal}', [GoalController::class, 'update'])->name('goals.update');
Route::delete('/goals/{goal}', [GoalController::class, 'destroy'])->name('goals.destroy');


