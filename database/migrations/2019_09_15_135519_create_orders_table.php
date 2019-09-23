<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedInteger('coupon_id')->nullable();
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');

            $table->unsignedInteger('packaging_id');
            $table->foreign('packaging_id')->references('id')->on('packagings')->onDelete('cascade');

            $table->float('price', 12, 4);

            $table->unsignedInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');

            $table->longText('notes')->nullable();

            $table->decimal('lat', 16,14)->nullable();

            $table->decimal('long', 16,14)->nullable();

            $table->integer('payment_type')->default(0);

            $table->integer('status')->default(0);

            $table->string('name');
            $table->string('phone');
            $table->string('address');

            $table->unsignedInteger('dalegate_id')->nullable();
            $table->foreign('dalegate_id')->references('id')->on('users')->onDelete('cascade');

            // $table->string('name', 100)->default('text');
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
        Schema::dropIfExists('orders');
    }
}
