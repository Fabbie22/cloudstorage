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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('shared', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('file_id');
            $table->string('owner_email');
            $table->string('recipient_email');

            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
        });

        Schema::create('users_has_files', function (Blueprint $table) {
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('files_id');
            $table->primary(['users_id', 'files_id']);
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('files_id')->references('id')->on('files')->onDelete('cascade');
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
