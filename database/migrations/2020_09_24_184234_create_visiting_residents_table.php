<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitingResidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visiting_residents', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique()->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);

            $table->string('phone_number', 13);
            $table->string('poi_id', 40)->unique();

            $table->integer('org_addr_barangay')->nullable();
            $table->integer('org_addr_municipality')->nullable();
            $table->integer('org_addr_province')->nullable();
            $table->integer('org_addr_region')->nullable();
          
            $table->string('address')->nullable();

            $table->integer('des_addr_barangay_id')->nullable();
            $table->integer('des_addr_municipality_id')->nullable();
            $table->integer('des_addr_province_id')->nullable();
            $table->integer('des_addr_region_id')->nullable();

            $table->integer('reason_visit');
            $table->integer('days_stay');
            $table->tinyInteger('status')->default(0);
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visiting_residents');
    }
}
