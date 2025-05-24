<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthenticationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('authentications', function (Blueprint $table) {
            $table->id(); // id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY
            $table->integer('emp_id'); // emp_id INT(10) NOT NULL
            $table->dateTime('authentication_datetime')->nullable(); // authentication_datetime DATETIME DEFAULT NULL
            $table->date('authentication_date')->nullable(); // authentication_date DATE DEFAULT NULL
            $table->time('authentication_time')->nullable(); // authentication_time TIME DEFAULT NULL
            $table->string('direction', 10)->nullable()->comment('IN or OUT'); // direction VARCHAR(10) NULL
            $table->string('device_name', 100)->nullable(); // device_name VARCHAR(100) NULL
            $table->string('device_serial_no', 50)->nullable(); // device_serial_no VARCHAR(50) NULL
            $table->string('person_name', 100)->nullable(); // person_name VARCHAR(100) NULL
            $table->string('card_no', 20)->nullable(); // card_no VARCHAR(20) NULL
            $table->timestamp('created_at')->useCurrent(); // created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authentications');
    }
}
