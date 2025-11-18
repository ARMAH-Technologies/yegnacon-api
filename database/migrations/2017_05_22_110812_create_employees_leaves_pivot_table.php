<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesLeavesPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_leaves', function (Blueprint $table) {
            $table->string('leave_id')->index();
            $table->foreign('leave_id')->references('id')->on('leaves')->onDelete('cascade');
            $table->string('employee_id')->index();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            //$table->primary(['employee_id', 'leave_id']);

            $table->integer('value2');
            $table->dateTime('fiscal_year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('employees_leaves');
    }
}
