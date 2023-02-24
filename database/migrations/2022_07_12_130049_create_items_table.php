<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classified_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('flyffapi_item_id')->nullable()->constrained('flyffapi_items', 'flyff_api_id')->nullOnDelete();
            $table->integer('general_level')->nullable();
            $table->integer('elemental_level')->nullable();
            $table->string('element_type')->nullable();
            $table->boolean('piercings')->default(false);
            $table->boolean('awake')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
