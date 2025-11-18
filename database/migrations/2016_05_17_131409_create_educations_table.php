<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->string('id', 40)->primary()->unique();
            $table->string('professional_id', 40)->index();
            $table->string('study_field')->nullable();
            $table->string('grad_level')->nullable();
            $table->string('school_name')->nullable();
            $table->date('started_date')->nullable();
            $table->date('ended_date')->nullable();
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
        Schema::drop('educations');
    }
}
