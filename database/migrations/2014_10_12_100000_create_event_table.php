<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sender')->default('系统');
            $table->integer('sender_id')->default(0);
            $table->tinyInteger('action');
            $table->integer('target')->default(0);
            $table->tinyInteger('target_type');
            $table->text('content')->nullable();
            $table->string('type');
            $table->integer('receiver')->default(0);
            $table->integer('is_read')->default(0);
            $table->timestamp('time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('event');
    }
}
