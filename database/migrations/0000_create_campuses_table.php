<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('unique_code')->nullable();
            $table->unsignedBigInteger('hq_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('payment_account_name')->nullable();
            $table->string('payment_bank_name')->nullable();
            $table->string('payment_account_number')->nullable();
            $table->text('payment_instructions')->nullable();
            $table->string('color_primary')->default('#1e40af');
            $table->string('color_secondary')->default('#3b82f6');
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('campuses'); }
};
