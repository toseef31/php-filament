<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('papers', function (Blueprint $table) {
            $table->foreignId('associate_editor_id')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('papers', function (Blueprint $table) {
            $table->dropForeign(['associate_editor_id']);
            $table->dropColumn('associate_editor_id');
        });
    }
};
