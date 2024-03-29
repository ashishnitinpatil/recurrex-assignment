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
            $table->text('description');
            $table->integer('price')->unsigned();
            $table->integer('stock')->unsigned();
            $table->date('date')->nullable();
            $table->string('image', 2083)->default(Product::DEFAULT_IMAGE);
            $table->enum('meal_course_type', Product::getMealCourseTypes());
            $table->enum('serving_time', Product::getServingTimes());
            $table->timestamps();
            // Ownership
            $table->integer('user_id')->unsigned()->nullable();
            // Nullable because we don't want to lose product orders even if product owner missing
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
