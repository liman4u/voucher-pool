<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVouchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->integer('offer_id')->unsigned();
            $table->integer('recipient_id')->unsigned()->nullable()->default(null);
            $table->dateTime('expires_at')->nullable()->default(null);
            $table->tinyInteger('is_used')->unsigned()->default(0);
            $table->dateTime('used_at')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}
