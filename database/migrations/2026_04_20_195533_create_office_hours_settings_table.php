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
        Schema::create('office_hours_settings', function (Blueprint $table) {
            $table->id();
            $table->json('work_days');           // e.g. [1,2,3,4,5] (Mon-Fri)
            $table->string('time_open');         // e.g. "08:00"
            $table->string('time_close');        // e.g. "17:00"
            $table->boolean('is_manually_open')->default(false);
            $table->boolean('is_manually_closed')->default(false);
            $table->text('note')->nullable();    // "Changed as per direction of city govt"
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('office_hours_settings');
    }
};
