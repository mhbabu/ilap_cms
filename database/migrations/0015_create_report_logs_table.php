<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('report_logs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type',50)->nullable();
            $table->json('data')->nullable();
            $table->unsignedBigInteger('generated_by')->nullable()->nullable()->index();
            $table->string('format',20)->default('PDF');
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('report_logs'); }
};
