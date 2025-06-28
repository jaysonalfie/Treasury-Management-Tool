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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('Account Name');
            $table->string('account_type')->nullable()->comment('Account Type');
            $table->string('currency')->nullable()->comment('Account Cuurency');
            $table->decimal('account_balance',19,6)->nullable()->comment('Account Balance');
            $table->integer('isActive')->nullable()->default(1)->comment('1=>yes, 0 =>no');
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
        Schema::dropIfExists('accounts');
    }
};
