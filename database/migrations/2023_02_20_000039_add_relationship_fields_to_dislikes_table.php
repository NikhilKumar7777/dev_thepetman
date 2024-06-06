<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDislikesTable extends Migration
{
    public function up()
    {
        Schema::table('dislikes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_7277622')->references('id')->on('users');
            $table->unsignedBigInteger('post_id')->nullable();
            $table->foreign('post_id', 'post_fk_7277623')->references('id')->on('posts');
        });
    }
}
