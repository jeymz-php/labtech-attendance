<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('archived_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('original_student_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('student_number');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('campus')->nullable();
            $table->string('course')->nullable();
            $table->string('year_level')->nullable();
            $table->string('role')->default('student');
            $table->string('reason')->default('rejected');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('archived_students');
    }
};
