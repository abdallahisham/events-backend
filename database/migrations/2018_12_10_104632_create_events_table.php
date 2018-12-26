<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('event_type_id')->index();
            $table->unsignedInteger('user_id');
            $table->string('address');
            $table->double('position_latitude')->nullable();
            $table->double('position_longitude')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_free')->default(0);
            $table->double('price')->nullable();
            $table->integer('max_tickets_count')->nullable();
            $table->boolean('has_sponsors')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
