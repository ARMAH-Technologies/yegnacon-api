<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('id', 40)->primary()->unique();
            $table->string('supplier_id', 40)->index();
            $table->string('name');
            $table->string('category')->nullable();
            $table->double('price', 20, 2)->nullable();
            $table->double('quantity', 20, 2)->nullable();
            $table->string('unit')->nullable();
            $table->text('description')->nullable();
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
        Schema::drop('products');
    }
}
