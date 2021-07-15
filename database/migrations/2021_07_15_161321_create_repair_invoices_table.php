<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->unsigned();
            $table->foreignId('equipament_id')->unsigned();
            $table->float('budget');
            $table->string('fail_description');
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
        Schema::dropIfExists('repair_invoices');
    }
}
