<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToViewsTable extends Migration
{
    public function up()
    {
        Schema::table('views', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_7277628')->references('id')->on('users');
            $table->unsignedBigInteger('post_id')->nullable();
            $table->foreign('post_id', 'post_fk_7277629')->references('id')->on('posts');
        });
    }
}
