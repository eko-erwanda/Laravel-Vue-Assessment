<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorMethodSalesStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('color_method_sales_styles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_style_id');
            $table->foreign('sales_style_id')->references('id')->on('sales_styles')->onDelete('cascade');
            $table->unsignedBigInteger('color_method_id');
            $table->foreign('color_method_id')->references('id')->on('color_methods')->onDelete('cascade');
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
        Schema::dropIfExists('color_method_sales_styles');
    }
}
