<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Product;

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
            $table->increments('id');
            $table->string('name');
            $table->string('SKU')->unique();
            $table->string('description');
            $table->integer('price')->unsigned();
            $table->integer('stock')->unsigned();
            $table->date('date')->nullable();
            $table->string('image')->default(Product::DEFAULT_IMAGE);
            $table->enum('meal_course_type', [Product::STARTER, Product::MAIN_COURSE, Product::DESSERT]);
            $table->enum('serving_time', [Product::BREAKFAST, Product::LUNCH, Product::DINNER]);
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
        Schema::drop('products');
    }
}
