<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameAndAddTypeColumnSupplierCategoryTableToProfileCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('supplier_category', 'profile_category');

        Schema::table('profile_category', function ($table) {
            $table->renameColumn('supplier_id', 'profile_id');
        });

        Schema::table('profile_category', function ($table) {
            $table->string('type')->default('Proforma')->after('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
