<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGadgetCheckItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gadget_check_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gadget_id')->unsigned();
            $table->string('name');
            $table->string('risk');
            $table->string('procedure');
            $table->string('level', 1);
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
        Schema::dropIfExists('gadget_check_items');
    }
}
