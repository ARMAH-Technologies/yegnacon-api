<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateProformaRequestProjectCosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proforma_request_project_costs', function (Blueprint $table) {
            $table->string('id', 40)->primary()->unique();
            $table->string('proforma_request_id', 40)->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type');
            $table->string('level');
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
        Schema::drop('proforma_request_project_costs');
    }
}
