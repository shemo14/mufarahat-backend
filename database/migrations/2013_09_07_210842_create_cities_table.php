<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('shipping')->nullable();;
            $table->timestamps();
        });

        $city = new \App\Models\City();
        $city->name_ar ='مكه';
        $city->name_ar ='maka';
        $city->shipping ='20';
        $city->save();

        $city = new \App\Models\City();
        $city->name_ar ='جده';
        $city->name_ar ='Gaddah';
        $city->shipping ='30';
        $city->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
