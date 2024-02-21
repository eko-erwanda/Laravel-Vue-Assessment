<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorNameSalesStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('color_name_sales_styles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('color_method_sales_style_id');
            $table->foreign('color_method_sales_style_id')->references('id')->on('color_method_sales_styles')->onDelete('cascade');
            $table->unsignedBigInteger('color_name_method_id');
            $table->foreign('color_name_method_id')->references('id')->on('color_name_methods')->onDelete('cascade');
            $table->integer('qty');
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
        Schema::dropIfExists('color_name_sales_styles');
    }
}
