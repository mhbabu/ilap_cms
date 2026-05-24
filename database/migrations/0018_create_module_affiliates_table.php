<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('module_affiliates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('module_id');
            $table->string('provider_name');
            $table->boolean('is_affiliated')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('module_affiliates'); }
};
