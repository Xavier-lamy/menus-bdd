<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuantitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quantities', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedInteger('quantity');
            
            $table->unsignedBigInteger('command_id');
            $table->foreign('command_id')->references('id')->on('commands')->onDelete('cascade');
            
            $table->unsignedBigInteger('recipe_id');
            $table->foreign('recipe_id')->references('id')->on('recipes');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quantities');
    }
}
