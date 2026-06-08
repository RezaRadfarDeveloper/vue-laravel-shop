<?php

use App\Models\Country;
use App\Models\User;
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
      Schema::table('customers', function (Blueprint $table) {
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->nullable();
            $table->string('status',4)->nullable();
            $table->string('country_code',4)->nullable();
            $table->foreign('country_code')->references('code')->on('countries');
            $table->foreignIdFor(User::class,'created_by')->nullable();
            $table->foreignIdFor(User::class,'updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
