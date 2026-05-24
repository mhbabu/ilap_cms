<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('system_document_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type',50)->nullable();
            $table->string('file_path');
            $table->unsignedBigInteger('uploaded_by')->nullable()->nullable()->index();
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('system_document_templates'); }
};
