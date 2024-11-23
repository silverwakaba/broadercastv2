<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up() : void{
        Schema::create('users_feed', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('base_link_id')->references('id')->on('base_link')->onDelete('cascade');
            $table->foreignId('users_link_tracker_id')->references('id')->on('users_link_tracker')->onDelete('cascade');
            $table->foreignId('base_status_id')->references('id')->on('base_status');
            $table->foreignId('base_feed_type_id')->nullable()->constrained()->references('id')->on('base_feed_type')->onDelete('cascade');
            $table->double('concurrent')->nullable()->default('0');
            $table->string('identifier')->unique();
            $table->string('thumbnail')->nullable();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->dateTime('published')->nullable();
            $table->dateTime('schedule')->nullable();
            $table->dateTime('actual_start')->nullable();
            $table->dateTime('actual_end')->nullable();
            $table->string('duration')->nullable();
            $table->string('reference')->nullable(); // For the fucking sake of Twitch (and prob other too)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void{
        Schema::dropIfExists('users_feed');
    }
};
