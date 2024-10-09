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
        // Create the 'files' table first
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->timestamps();
        });

        // Create the 'shared' table next
        Schema::create('shared', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('file_id'); // Use unsignedBigInteger to match the 'id' type in files table
            $table->string('owner_email');
            $table->string('recipient_email');

            // Foreign key constraint
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
        });

        // Create the 'users_has_files' table next
        Schema::create('users_has_files', function (Blueprint $table) {
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('files_id'); // Use unsignedBigInteger to match the 'id' type in files table
            $table->primary(['users_id', 'files_id']);
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('files_id')->references('id')->on('files')->onDelete('cascade');
        });

        // Create the 'deleted_file_properties' table last
        Schema::create('deleted_file_properties', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_has_files');
        Schema::dropIfExists('shared');
        Schema::dropIfExists('files');
        Schema::dropIfExists('deleted_file_properties');
    }
};
