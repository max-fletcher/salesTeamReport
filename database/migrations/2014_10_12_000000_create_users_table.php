<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->unsignedInteger('representative_id')->unique()->nullable();
            $table->string('name');
            $table->string('username')->unique();
            // $table->string('email');
            // $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('isAdmin')->default(0)->nullable();
            $table->rememberToken();
            $table->timestamps();                        
        });
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

