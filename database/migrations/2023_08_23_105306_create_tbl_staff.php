<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblStaff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->Increments('id_staff');
            $table->string('staff_name');
            $table->string('staff_phone');
            $table->string('staff_email');
            $table->string('staff_username');
            $table->string('staff_password');
            $table->string('is_working');
            $table->string('is_station_master');
            $table->string('id_posision');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff');
    }
}
