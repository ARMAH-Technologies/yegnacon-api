<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActiveProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_projects', function (Blueprint $table) {
            $table->string('id', 40)->primary()->unique();
            $table->string('project_owner_id', 40)->index();
            $table->string('name');
            $table->string('type');
            $table->string('category');
            $table->string('project_option');
            $table->string('location');
            $table->string('expected_time');
            $table->text('description');
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
        Schema::drop('active_projects');
    }
}
