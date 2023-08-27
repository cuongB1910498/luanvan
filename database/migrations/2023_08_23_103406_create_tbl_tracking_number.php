<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblTrackingNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_tracking_number', function (Blueprint $table) {
            $table->Increments('id_tracking');
            $table->string('address_sent');
            $table->string('province_sent');
            $table->string('district_sent');
            $table->string('name_sent');
            $table->string('phone_sent');
            $table->string('address_receive');
            $table->string('district_receive');
            $table->string('province_receive');
            $table->string('name_receive');
            $table->string('phone_receive');
            $table->string('img_receive');
            $table->string('type_sending');
            $table->string('demension');
            $table->string('weight');
            $table->string('id_user');
            $table->timestamps('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_trackingnumber');
    }
}
