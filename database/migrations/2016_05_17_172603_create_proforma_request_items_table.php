<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProformaRequestItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proforma_request_items', function (Blueprint $table) {
            $table->string('id', 40)->primary()->unique();
            $table->string('proforma_request_id', 40)->index();
            $table->string('category_id', 40)->index();
            $table->string('item_name');
            $table->float('quantity');
            $table->string('unit');
            $table->text('description');
            $table->string('status', 10);
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
        Schema::drop('proforma_request_items');
    }
}
