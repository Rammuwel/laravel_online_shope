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
        Schema::table('products', function (Blueprint $table) {
            // Modify the column to text type
            $table->text('description')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         // Ensure all descriptions are within the 255 character limit before changing back
        // DB::table('products')->update([
        //     'description' => DB::raw('LEFT(description, 255)')
        // ]);

        // Modify the column back to string type with length 255
        Schema::table('products', function (Blueprint $table) {
            $table->string('description', 255)->change();
        });
    }

};
