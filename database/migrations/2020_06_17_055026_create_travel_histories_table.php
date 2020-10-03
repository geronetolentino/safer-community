<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_histories', function (Blueprint $table) {
            $table->id();
            //$table->integer('visitor_id')->unsigned();
            $table->foreignId('visit_id');
            $table->string('address');
            $table->string('date_visited');
            $table->string('length_of_stay');
            $table->timestamps();
        });

        Schema::table('travel_histories', function($table) {
            //$table->foreign('visitor_id')->references('id')->on('visitors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel_histories');
    }
}
