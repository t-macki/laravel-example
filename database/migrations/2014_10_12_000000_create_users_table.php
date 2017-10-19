<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('name')->default(null)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('email_temp')->default(null)->nullable()->comment('仮登録メールアドレス');
            $table->string('email_before')->default(null)->nullable()->comment('変更前メールアドレス');
            $table->string('email_withdrawal')->default(null)->nullable()->comment('退会時メールアドレス');
            $table->tinyInteger('status')->default(0);
            $table->string('email_verify_token')->nullable();
            $table->timestamp('email_verify_time')->nullable();
            $table->timestamp('email_verify_sent_at')->nullable();
            $table->tinyinteger('email_verify_status')->default(0);
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
