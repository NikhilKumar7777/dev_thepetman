<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone_no');
            $table->string('addressline_1');
            $table->string('addressline_2');
            $table->string('city');
            $table->string('zip_code');
            $table->string('state')->nullable();
            $table->string('type');
            $table->boolean('default')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
