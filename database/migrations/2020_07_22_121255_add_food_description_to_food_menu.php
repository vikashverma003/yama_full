<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFoodDescriptionToFoodMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('food_menu', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->string('food_description')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('food_menu', function (Blueprint $table) {
            $table->dropColumn(['image', 'food_description']);

        });
    }
}
