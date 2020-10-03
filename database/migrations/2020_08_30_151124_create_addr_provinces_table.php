<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddrProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addr_provinces', function (Blueprint $table) {
            $table->id();
            $table->string('province',100);
            $table->integer('addr_region_id');
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
        Schema::dropIfExists('addr_provinces');
    }
}
