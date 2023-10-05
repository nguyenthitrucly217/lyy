<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up()
    {
        Schema::create('nttl_order', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->default(1);
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('address');
            $table->string('note');
            $table->timestamps(); //created_at, updated_at
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
        Schema::dropIfExists('nttl_order');
    }
}
