<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthDataDiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_data_diaries', function (Blueprint $table) {
            $table->id();
            $table->integer('health_data_id');
            $table->integer('procedures');
            $table->integer('diagnosis');  
            $table->timestamp('data_date', 0);  
            $table->integer('hospital_id');
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
        Schema::dropIfExists('health_data_diaries');
    }
}
