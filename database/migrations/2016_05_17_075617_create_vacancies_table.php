<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->string('id', 40)->primary()->unique();
            $table->string('item_id', 40)->index();//contractor_id, supplier_id, company_id
            $table->string('item_type');//Contractor, Supplier, Company
            $table->string('title');
            $table->string('category')->nullable();
            $table->string('contract')->nullable();
            $table->string('education_level')->nullable();
            $table->string('experience')->nullable();
            $table->double('salary', 20, 2)->nullable();
            $table->string('work_place')->nullable();
            $table->text('description')->nullable();
            $table->date('closing_date')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vacancies');
    }
}
