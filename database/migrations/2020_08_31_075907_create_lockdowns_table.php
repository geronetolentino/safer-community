<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLockdownsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lockdowns', function (Blueprint $table) {
            $table->id();
            $table->string('parent_location');
            $table->integer('location_id');
            $table->integer('expire_days');
            $table->integer('set_by');
            $table->mediumText('reason');
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
        Schema::dropIfExists('lockdowns');
    }
}
