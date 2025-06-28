<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->string('from_currency')->nullable()->comment('Currency from');
            $table->string('to_currency')->nullable()->comment('Currency To');
            $table->bigInteger('rate')->nullable();
            $table->timestamp('rate_date')->nullable();
            $table->integer('isActive')->nullable()->default(1)->comment('1=>yes , 2=>no');
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamp('created_on')->nullable();
            $table->unsignedBigInteger('edited_by')->nullable();
            $table->timestamp('edited_on')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
    }
};
