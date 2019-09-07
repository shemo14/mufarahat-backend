<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone');
            $table->string('address');
            $table->unsignedInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->timestamps();
        });

        $warehouse = new \App\Models\Warehouse();
        $warehouse->name ='مستودع مكه ';
        $warehouse->phone ='0103333333';
        $warehouse->address ='السعوديه - مكه';
        $warehouse->city_id =1;
        $warehouse->save();
        
        $warehouse = new \App\Models\Warehouse();
        $warehouse->name ='مستودع جده ';
        $warehouse->phone ='0103333333';
        $warehouse->address ='السعوديه - جده';
        $warehouse->city_id =2;
        $warehouse->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouses');
    }
}
