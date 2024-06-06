<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFollowsTable extends Migration
{
    public function up()
    {
        Schema::table('follows', function (Blueprint $table) {
            $table->unsignedBigInteger('follower_id')->nullable();
            $table->foreign('follower_id', 'follower_fk_6870982')->references('id')->on('users');
            $table->unsignedBigInteger('following_id')->nullable();
            $table->foreign('following_id', 'following_fk_6870986')->references('id')->on('users');
        });
    }
}
