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
            $table->increments('id');
            $table->string('user_name')->unique();
            $table->string('mandali_name')->nullable();
            $table->string('mandali_code');
            $table->text('mandali_address')->nullable();
            $table->string('gst_num')->nullable();
            $table->string('reg_num')->nullable();
            $table->string('gender')->nullable();
            $table->string('lang')->nullable();
            $table->string('email')->unique();
            $table->string('mobile')->unique();
            $table->string('role')->nullable();
            $table->string('status')->nullable();
            $table->string('profile')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('insertedByUserId')->unsigned();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('insertedByUserId')->references('id')->on('users')->onDelete('cascade');
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
