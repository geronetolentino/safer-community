<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_data', function (Blueprint $table) {
            $table->id();
            $table->string('poi_id', 20);
            $table->date('test_date');
            $table->string('test_result', 50);
            $table->string('covid_status', 50);
            $table->integer('asymptomatic');
            $table->integer('postive_days');
            $table->mediumtext('remarks');
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
        Schema::dropIfExists('health_data');
    }
}
