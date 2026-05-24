<?php 

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Campus;
use App\Models\EvaluationStatus;
use App\Models\Finance;
use App\Models\Handler;
use App\Models\Lead;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Carbon;

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
            $table->string('hq_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('payment_account_name')->nullable();
            $table->string('payment_bank_name')->nullable();
            $table->string('payment_account_number')->nullable();
            $table->text('payment_instructions')->nullable();
            $table->string('color_primary')->nullable();
            $table->string('color_secondary')->nullable();
            $table->string('logo')->nullable();
            $table->string('opening_hours')->nullable();
            $table->bigInteger('manager_user_id')->nullable();
            $table->timestamps();
        });
    }
};
