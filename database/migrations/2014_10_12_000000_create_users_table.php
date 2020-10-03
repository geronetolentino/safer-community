<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('territory',10)->nullable();
            $table->integer('addr_barangay_id')->nullable();
            $table->integer('addr_municipality_id')->nullable();
            $table->integer('addr_province_id')->nullable();
            $table->integer('addr_region_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
