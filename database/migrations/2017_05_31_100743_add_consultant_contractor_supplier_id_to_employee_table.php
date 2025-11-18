<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConsultantContractorSupplierIdToEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('contractor_id', 40);
            $table->string('consultant_id', 40);
            $table->string('supplier_id', 40);
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
            $table->dropColumn('contractor_id');
            $table->dropColumn('consultant_id');
            $table->dropColumn('supplier_id');
            //$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }
}
