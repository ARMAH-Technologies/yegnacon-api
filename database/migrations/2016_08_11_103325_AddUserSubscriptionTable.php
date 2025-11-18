<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddUserSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_packages', function(Blueprint $table) {
            $table->string('id',40)->primary()->unique();
            $table->string('package',50);
            $table->integer("duration_in_months");
            $table->double('price', 20, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('sales', function(Blueprint $table) {
            $table->string('id', 40)->primary()->unique();
            $table->string('full_name',100);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('user_subscriptions', function(Blueprint $table) {
            $table->string('id', 40)->primary()->unique();
            $table->string('user_id', 40)->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('sales_id', 40)->index();
            $table->foreign('sales_id')->references('id')->on('sales')->onDelete('cascade');
            $table->string('subscription_package_id', 40)->index();
            $table->foreign('subscription_package_id')->references('id')->on('subscription_packages')->onDelete('cascade');
            $table->date('started_date');
            $table->date('expiration_date');

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
        Schema::drop('user_subscriptions');
        Schema::drop('subscription_packages');
        Schema::drop('sales');
    }
}
