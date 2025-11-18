<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenders', function (Blueprint $table) {
            $table->string('id', 40)->primary()->unique();
            $table->string('item_id', 40)->index();//contractor_id, supplier_id, company_id
            $table->string('item_type');//Contractor, Supplier, Company
            $table->string('title');
            $table->string('category')->nullable();
            $table->double('document_price', 20, 2)->nullable();
            $table->double('bid_bond', 20, 2)->nullable();
            $table->date('opening_date')->nullable();
            $table->date('closing_date')->nullable();
            $table->text('description')->nullable();
            $table->string('status');
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
        Schema::drop('tenders');
    }
}
