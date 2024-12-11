<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up() : void{
        Schema::create('users_fanbox_attachment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_fanbox_submission_id')->references('id')->on('users_fanbox_submission')->onDelete('cascade');
            $table->foreignId('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('base_mime_id')->references('id')->on('base_mime')->onDelete('cascade');
            $table->unsignedBigInteger('size')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void{
        Schema::dropIfExists('users_fanbox_attachment');
    }
};
