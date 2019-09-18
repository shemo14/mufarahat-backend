<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password');
            $table->string('address');
            $table->string('code')->nullable();
            $table->string('device_id')->nullable();
            $table->string('avatar')->default('default.png');
            $table->integer('active')->default(0);
            $table->integer('checked')->default(0);
            $table->integer('role')->default('0');
            $table->integer('isNotify')->default(1);
            $table->enum('type', ['user', 'delegate'])->default('user');
            $table->decimal('lat', 16,14)->nullable();
            $table->decimal('long', 16,14)->nullable();
            $table->string('lang')->default('ar');

            $table->unsignedInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');

            $table->rememberToken();
            $table->timestamps();
        });

        $user = new \App\User();
        $user->name ='اوامر الشبكه';
        $user->email ='aait@info.com';
        $user->password =bcrypt(123456);
        $user->phone ='123456789';
        $user->role ='1';
        $user->device_id ='1111111111';
        $user->address ='مصر - المنصوره';
        $user->city_id =null;
        $user->save();

        $user            = new \App\User();
        $user->name      ='مندوب';
        $user->email     ='delegate@info.com';
        $user->password  =bcrypt(123456);
        $user->phone     ='01022222222';
        $user->role      ='0';
        $user->device_id ='1111111111';
        $user->address   ='السعوديه - جده';
        $user->type      ='delegate';
        $user->city_id   =2;
        $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
