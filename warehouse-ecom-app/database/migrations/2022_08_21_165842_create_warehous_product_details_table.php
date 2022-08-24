<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehous_product_details', function (Blueprint $table) {
            $table->id();
            $table->string('sku_id')->nullable();
            $table->string('name')->nullable();
            $table->string('img')->nullable();
            $table->string('category')->nullable();
            $table->string('warehouse_id')->nullable();
            $table->longText('specification')->nullable();
            $table->longText('buying_price')->nullable();
            $table->longText('selling_price')->nullable();
            $table->longText('quantiry')->nullable();
            $table->string('stock_status')->default('In stock');
            $table->string('is_offer')->nullable();
            $table->string('status')->default('Inactive');
            $table->string('author')->default('Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehous_product_details');
    }
};
