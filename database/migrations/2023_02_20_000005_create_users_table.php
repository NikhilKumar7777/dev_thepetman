<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->datetime('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('approved')->default(0)->nullable();
            $table->boolean('verified')->default(0)->nullable();
            $table->datetime('verified_at')->nullable();
            $table->string('verification_token')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('social_token')->nullable();
            $table->string('social_platform')->nullable();
            $table->string('profile_status')->nullable();
            $table->string('city')->nullable();
            $table->longText('about')->nullable();
            $table->longText('bio')->nullable();
            $table->string('age')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
