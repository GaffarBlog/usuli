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
        Schema::table('frontend_users', function (Blueprint $table) {
            $table->boolean('is_writer')->default(false);
            $table->enum('writer_request_status', ['pending', 'approved', 'rejected'])->nullable();
            $table->text('writer_request_reason')->nullable();
            $table->timestamp('writer_requested_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('frontend_users', function (Blueprint $table) {
            $table->dropColumn(['is_writer', 'writer_request_status', 'writer_request_reason', 'writer_requested_at']);
        });
    }
};
