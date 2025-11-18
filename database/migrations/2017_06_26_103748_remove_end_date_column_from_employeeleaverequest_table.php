<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveEndDateColumnFromEmployeeleaverequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_leave_requests', function (Blueprint $table) {
            $table->dropColumn('end_date');
            //$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dateTime('end_date')->nullable();
            //$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }
}
