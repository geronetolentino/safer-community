<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('required_documents_id');
            $table->integer('expiry_date');
            $table->integer('status');
            $table->integer('group_id');
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
        Schema::dropIfExists('users_documents');
    }
}
