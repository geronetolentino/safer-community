<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstablishmentVisitorLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('establishment_visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->string('poi_id');
            $table->integer('scanner_id');
            $table->string('est_code', 10);
            $table->string('checkin',20)->default(null);
            $table->string('checkout',20)->default(null);
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
        Schema::dropIfExists('establishment_visitor_logs');
    }
}
