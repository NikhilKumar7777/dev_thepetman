<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('body')->nullable();
            $table->string('slug')->unique();
            $table->integer('like_count');
            $table->integer('unlike_count');
            $table->integer('view_count');
            $table->boolean('is_report')->default(0)->nullable();
            $table->integer('answer_count');
            $table->string('type');
            $table->string('option_1');
            $table->string('option_2');
            $table->string('option_3')->nullable();
            $table->string('option_4')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
