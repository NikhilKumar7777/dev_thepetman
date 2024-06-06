<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToReportsAbusesTable extends Migration
{
    public function up()
    {
        Schema::table('reports_abuses', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_6813025')->references('id')->on('users');
            $table->unsignedBigInteger('post_id')->nullable();
            $table->foreign('post_id', 'post_fk_6813026')->references('id')->on('posts');
        });
    }
}
