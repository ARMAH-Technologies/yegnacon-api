<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    
    public function up()
    {
        Schema::create('users', function(Blueprint $table) {
            $table->string('id', 40)->primary()->unique();
            $table->string('name', 60);
            $table->string('email', 60)->unique();
            $table->string('password', 60);
            $table->string('profile_type', 30);
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('users');
    }
}
