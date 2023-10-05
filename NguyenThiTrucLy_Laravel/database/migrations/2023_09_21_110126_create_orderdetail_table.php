<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderdetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up()
    {
        Schema::create('nttl_orderdetail', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_id')->default(0);
            $table->unsignedInteger('product_id')->default(0);
            $table->float('price');
            $table->unsignedInteger('quality')->default(1);
            $table->float('amount');
            $table->timestamps(); //created_at, updated_at
            $table->unsignedInteger('updated_by')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     */
    public function down()
    {
        Schema::dropIfExists('nttl_orderdetail');
    }
}
