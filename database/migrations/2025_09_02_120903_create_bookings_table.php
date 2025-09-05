<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('availability_id'); // FK to availability
        $table->unsignedBigInteger('teacher_id');      // FK to teacher
        $table->unsignedBigInteger('student_id');      // FK to student
        $table->timestamps();

        $table->foreign('availability_id')->references('id')->on('availabilities')->onDelete('cascade');
        $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
