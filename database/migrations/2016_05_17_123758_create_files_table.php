<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->string('id', 40)->primary()->unique();
            $table->string('item_id', 40)->index();//user_id, active_project_id, project_id, product_id, news_id
            $table->string('file_path');
            $table->string('extension');
            $table->string('original');
            $table->string('thumbnail');
            $table->string('large_image');
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
        Schema::drop('files');
    }
}
