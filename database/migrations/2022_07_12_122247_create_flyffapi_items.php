<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlyffapiItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flyffapi_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('flyff_api_id')->unique();
            $table->string('name');
            $table->string('category');
            $table->string('subcategory')->nullable();
            $table->string('rarity');
            $table->foreignId('class_id')->nullable()->constrained('flyffapi_classes', 'flyff_api_id')->onUpdate('cascade')->onDelete('cascade');
            $table->string('level');
            $table->string('sex')->nullable();
            $table->boolean('tradable');
            $table->string('icon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flyffapi_items');
    }
}
