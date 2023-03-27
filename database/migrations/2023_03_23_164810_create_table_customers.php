<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->string('cccd')->nullable()->default(null);
            $table->string('address')->nullable()->default(null);
            $table->longText('note')->nullable()->default(null);
            $table->tinyInteger('is_bad')->nullable()->default(0);
            $table->tinyInteger('is_sms_spamed')->nullable()->default(0);
            $table->tinyInteger('is_zalo_spamed')->nullable()->default(0);
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
        Schema::dropIfExists('customers');
    }
}
