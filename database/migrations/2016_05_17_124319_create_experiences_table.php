<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->string('id', 40)->primary()->unique();
            $table->string('professional_id', 40)->index();
            $table->string('company')->nullable();
            $table->string('position')->nullable();
            $table->string('description')->nullable();
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
        Schema::drop('experiences');
    }
}
