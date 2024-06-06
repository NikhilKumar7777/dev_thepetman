<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCommentsTable extends Migration
{
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_6813151')->references('id')->on('users');
            $table->unsignedBigInteger('post_id')->nullable();
            $table->foreign('post_id', 'post_fk_6813152')->references('id')->on('posts');
            $table->unsignedBigInteger('answer_id')->nullable();
            $table->foreign('answer_id', 'answer_fk_6813158')->references('id')->on('answers');
        });
    }
}
