<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->string('id', 40)->primary()->unique();
            $table->string('item_id', 40)->index();//user_id, company_id
            $table->string('item_type');//User, Company
            $table->string('website')->nullable();
            $table->string('phone_number_1')->nullable();
            $table->string('phone_number_2')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('sub_city')->nullable();
            $table->string('house_no')->nullable();
            $table->string('specific_address')->nullable();
            $table->double('latitude',30,20)->nullable();
            $table->double('longitude',30,20)->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('linkidin_link')->nullable();
            $table->string('google_link')->nullable();
            $table->string('instagram_link')->nullable();
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
        Schema::drop('addresses');
    }
}
