<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->string('id', 40)->primary()->unique();
            $table->string('profile_id', 40)->index();//contractor_id, consultant_id
            $table->string('profile_type');//Consultant, Contractor
            $table->string('name');
            $table->string('category')->nullable();
            $table->string('client')->nullable();
            $table->text('description')->nullable();
            $table->string('elapsed_time')->nullable();
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
        Schema::drop('projects');
    }
}
