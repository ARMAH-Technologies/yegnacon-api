<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesLeavesPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::create('companies_leaves', function (Blueprint $table) {
           // $table->string('leave_id', 40)->index();
            //$table->foreign('leave_id')->references('id')->on('leaves')->onDelete('cascade');
            //$table->string('company_id', 40)->index();
            //$table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
           // $table->primary(['co_id', 'le_id'], 80);

            //$table->integer('value');
        //});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       // Schema::drop('companies_leaves');
    }
}
