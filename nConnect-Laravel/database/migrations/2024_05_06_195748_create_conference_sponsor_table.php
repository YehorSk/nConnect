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
        Schema::create('conference_sponsor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("conference_id");
            $table->unsignedBigInteger("sponsor_id");

            $table->foreign("sponsor_id")->references("id")->on("sponsors")->onDelete("cascade");
            $table->foreign("conference_id")->references("id")->on("conferences")->onDelete("cascade");

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
        Schema::dropIfExists('conference_sponsor');
    }
};
