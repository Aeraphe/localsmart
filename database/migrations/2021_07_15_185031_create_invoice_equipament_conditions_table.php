<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceEquipamentConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_equipament_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repair_invoice_id')->constrained()->onDelete('cascade');
            $table->foreignId('equipament_id')->constrained()->onDelete('cascade');
            $table->string('name');
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
        Schema::dropIfExists('invoice_equipament_conditions');
    }
}
