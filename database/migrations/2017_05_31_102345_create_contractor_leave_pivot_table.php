<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractorLeavePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractors_leaves', function (Blueprint $table) {
            $table->string('leave_id', 40)->index();
            //$table->foreign('leave_id')->references('id')->on('leaves')->onDelete('cascade');
            $table->string('contractor_id', 40)->index();
            //$table->foreign('contractor_id')->references('id')->on('contractors')->onDelete('cascade');
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
        Schema::drop('contractors_leaves');
    }
}
