<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstablishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('establishments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('parent_id');
            $table->string('name',50);
            $table->string('description',50);
            $table->string('address',50);
            $table->integer('addr_barangay_id')->nullable();
            $table->integer('addr_municipality_id')->nullable();
            $table->integer('addr_province_id')->nullable();
            $table->integer('addr_region_id')->nullable();
            $table->string('logo');
            $table->string('est_code',50);
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('establishments');
    }
}
