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
        Schema::create('customer_addressses', function (Blueprint $table) {
            $table->id();
             $table->foreignId('user_id')->constrained()->onDelete('cascade');
             $table->string('first_name');
             $table->string('last_name');
             $table->string('email');
             $table->string('mobile');
             $table->string('country_id');
             $table->string('address');
             $table->string('apartment')->nallable();
             $table->string('city');
             $table->string('state');
             $table->string('zip');
             $table->text('notes')->nallable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_addressses');
    }
};
