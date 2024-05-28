<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stage_id')->constrained()->onDelete('cascade');
            $table->foreignId('speaker_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('conference_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('short_desc');
            $table->longText('long_desc')->nullable();
            $table->integer('capacity')->nullable();
            $table->integer('remaining_spots')->nullable();
            $table->boolean('is_lecture')->default(true);
            $table->time('start_time');
            $table->time('end_time');
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
        Schema::dropIfExists('lectures');
    }
};
