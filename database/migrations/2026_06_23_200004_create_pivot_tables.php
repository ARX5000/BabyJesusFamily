<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Many-to-many: students <-> activities
        Schema::create('student_activity', function (Blueprint $table) {
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('activity_id')->constrained('activities')->onDelete('cascade');
            $table->timestamp('joined_at')->useCurrent();
            $table->primary(['student_id', 'activity_id']);
        });

        // Many-to-many: teachers <-> classes
        Schema::create('teacher_class', function (Blueprint $table) {
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('school_classes')->onDelete('cascade');
            $table->primary(['teacher_id', 'class_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_activity');
        Schema::dropIfExists('teacher_class');
    }
};
