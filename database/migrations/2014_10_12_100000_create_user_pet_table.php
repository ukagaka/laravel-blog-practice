<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_pet', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unique();
            $table->integer('pet_id');
            $table->string('nick')->nullable();
            $table->string('uname')->nullable();
            $table->integer('exp')->default(0);
            $table->json('config')->nullable();
            $table->json('state')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::drop('user_pet');
    }
}
