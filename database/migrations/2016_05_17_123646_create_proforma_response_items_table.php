<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProformaResponseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proforma_response_items', function (Blueprint $table) {
            $table->string('id', 40)->primary()->unique();
            $table->string('proforma_response_id', 40)->index();
            $table->string('proforma_request_item_id', 40)->index();
            $table->double('quantity', 20,2);
            $table->double('price', 20,2);
            $table->string('unit');
            $table->string('delivery_type');
            $table->date('delivery_date');
            $table->text('description');
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
        Schema::drop('proforma_response_items');
    }
}
