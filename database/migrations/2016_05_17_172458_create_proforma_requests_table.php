<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateProformaRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proforma_requests', function (Blueprint $table) {
            $table->string('id', 40)->primary()->unique();
            $table->string('requester_id', 40)->index();//contractor_id, project_owner_id
            $table->string('requester_type');//contractor, project_owner
            $table->string('type');//Product, ProjectCost, ConsultantCost
            $table->string('status', 10);
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
        Schema::drop('proforma_requests');
    }
}
