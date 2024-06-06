<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAnimalsTable extends Migration
{
    public function up()
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->unsignedBigInteger('breed_id')->nullable();
            $table->foreign('breed_id', 'breed_fk_6931396')->references('id')->on('pets');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_7116040')->references('id')->on('users');
        });
    }
}
