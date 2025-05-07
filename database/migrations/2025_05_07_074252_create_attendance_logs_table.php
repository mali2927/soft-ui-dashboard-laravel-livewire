<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees');
            $table->foreignId('biometric_device_id')->constrained('biometric_devices');
            $table->timestamp('check_in')->nullable();
            $table->timestamp('check_out')->nullable();
            $table->decimal('working_hours', 5, 2)->nullable();
            $table->enum('status', ['present', 'absent', 'late', 'early_departure', 'on_leave'])->default('present');
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            $table->index(['employee_id', 'check_in']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendance_logs');
    }
};