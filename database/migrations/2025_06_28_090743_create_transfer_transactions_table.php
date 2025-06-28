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
        Schema::create('transfer_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('from_account_id')->nullable()->comment('Account From');
            $table->integer('to_account_id')->nullable()->comment('Account To');
            $table->decimal('Amount',19,6)->nullable()->comment('Amount Transfered');
            $table->decimal('Converted_Amount',19,6)->nullable()->comment('Amount Converted');
            $table->decimal('fx_rate',10,5)->nullable()->comment('FX conversion rate');
            $table->integer('status')->default(0)->comment('1=>completed,0=>pending,2=>failed')->nullable();
            $table->longText('description')->nullable();
            $table->timestamp('transfer_date')->nullable();
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
        Schema::dropIfExists('transfer_transactions');
    }
};
