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
        Schema::create('conference_stage', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("conference_id");
            $table->unsignedBigInteger("stage_id");

            $table->foreign("conference_id")->references("id")->on("conferences")->onDelete("cascade");
            $table->foreign("stage_id")->references("id")->on("stages")->onDelete("cascade");
            $table->string('date');
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
        Schema::dropIfExists('conference_stage');
    }
};
