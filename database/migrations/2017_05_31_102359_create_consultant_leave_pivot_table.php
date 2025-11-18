<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultantLeavePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultants_leaves', function (Blueprint $table) {
            $table->string('leave_id', 40)->index();
           // $table->foreign('leave_id')->references('id')->on('leaves')->onDelete('cascade');
            $table->string('consultant_id', 40)->index();
            //$table->foreign('consultant_id')->references('id')->on('consultants')->onDelete('cascade');
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
        Schema::drop('consultants_leaves');
    }
}
