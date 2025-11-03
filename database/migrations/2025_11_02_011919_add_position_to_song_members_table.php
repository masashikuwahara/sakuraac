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
        Schema::table('song_members', function (Blueprint $table) {
            $table->unsignedTinyInteger('row')->nullable()->after('is_center');
            $table->unsignedTinyInteger('position')->nullable()->after('row');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('song_members', function (Blueprint $table) {
            //
        });
    }
};
