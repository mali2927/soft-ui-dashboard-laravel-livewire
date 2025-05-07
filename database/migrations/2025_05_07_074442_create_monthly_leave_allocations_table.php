<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('monthly_leave_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees');
            $table->date('month_year');
            $table->integer('allocated_leaves')->default(4);
            $table->integer('used_leaves')->default(0);
            $table->decimal('carry_over_amount', 12, 2)->default(0);
            $table->boolean('is_processed')->default(false);
            $table->timestamps();
            
            $table->unique(['employee_id', 'month_year']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('monthly_leave_allocations');
    }
};