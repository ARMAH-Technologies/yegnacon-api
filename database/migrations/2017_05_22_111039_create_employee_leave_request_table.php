<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeLeaveRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_leave_requests', function (Blueprint $table) {
            $table->string('id', 40)->primary()->unique();
            $table->string('employee_id', 40);
            $table->string('leave_id', 40);

            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('number_of_days');

            $table->string('status');
            $table->string('remark');

//            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
//            $table->foreign('leave_id')->references('id')->on('leaves')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('employee_leave_requests');
    }
}
