<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->unsignedBigInteger('payer_id')->index();
            $table->unsignedBigInteger('campus_id')->index();
            $table->unsignedBigInteger('student_id')->nullable()->index();
            $table->decimal('amount', 12, 2);
            $table->string('type');      // tuition, installation, refund, misc
            $table->string('status')->default('pending'); // pending, completed, rejected, approved, failed
            $table->string('account_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('transaction_ref')->nullable();
            $table->text('notes')->nullable();
            $table->string('installment_of')->nullable();
            $table->unsignedBigInteger('parent_payment_id')->nullable()->index();
            $table->boolean('is_hq_visible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('payments'); }
};
