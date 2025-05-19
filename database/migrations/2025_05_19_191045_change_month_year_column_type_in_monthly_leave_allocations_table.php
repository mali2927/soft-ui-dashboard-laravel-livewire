<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('monthly_leave_allocations', function (Blueprint $table) {
        $table->date('month_year')->change(); // Change to proper date type
        // OR if using string approach:
        // $table->string('month_year', 7)->change();
    });
}

public function down()
{
    Schema::table('monthly_leave_allocations', function (Blueprint $table) {
        $table->string('month_year', 7)->change(); // Revert if needed
    });
}
};
