<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pet', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('nick');
            $table->integer('user_id');
            $table->json('demand')->nullable();
            $table->json('config')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pet');
    }
}
