<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up()
    {
        Schema::create('nttl_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('category_id')->default(0);
            $table->unsignedInteger('brand_id')->default(0);
            $table->string('name', 1000);
            $table->string('slug', 1000);
            $table->string('type', 255);

            $table->float('price');
            $table->float('pricesale');
            $table->string('image', 1000);
            $table->unsignedInteger('quality')->default(0);
            $table->mediumtext('detail');
            $table->string('metakey');
            $table->string('metadesc');
            $table->timestamps();//created_at, updated_at
            $table->unsignedInteger('created_by')->default(1);
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedTinyInteger('status')->default(2);


        });
    }

    /**
     * Reverse the migrations.
     *
     */
    public function down()
    {
        Schema::dropIfExists('nttl_product');
    }
}
