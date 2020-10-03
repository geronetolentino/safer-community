<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddrMunicipalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addr_municipalities', function (Blueprint $table) {
            $table->id();
            $table->string('municipality',100);
            $table->integer('addr_province_id');
            $table->string('coor_lon',10)->nullable();
            $table->string('coor_lat',10)->nullable();
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
        Schema::dropIfExists('addr_municipalities');
    }
}
