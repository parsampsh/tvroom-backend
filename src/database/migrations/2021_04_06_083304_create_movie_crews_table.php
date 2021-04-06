<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieCrewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_crews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('crew_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('role');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movie_crews');
    }
}
