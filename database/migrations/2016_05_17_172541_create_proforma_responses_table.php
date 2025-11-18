<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateProformaResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proforma_responses', function (Blueprint $table) {
            $table->string('id', 40)->primary()->unique();
            $table->string('proforma_request_id', 40)->index();
            $table->string('responder_id', 40)->index();
            $table->string('responder_type', 40)->index();
            $table->date('validity_date')->nullable();
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
        Schema::drop('proforma_responses');
    }
}
