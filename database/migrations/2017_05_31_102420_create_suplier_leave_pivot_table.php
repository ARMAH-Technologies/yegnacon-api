<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuplierLeavePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves_suppliers', function (Blueprint $table) {
            $table->string('leave_id', 40)->index();
            //$table->foreign('leave_id')->references('id')->on('leaves')->onDelete('cascade');
            $table->string('supplier_id', 40)->index();
            //$table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            // $table->primary(['co_id', 'le_id'], 80);

            $table->integer('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('leaves_suppliers');
    }
}
