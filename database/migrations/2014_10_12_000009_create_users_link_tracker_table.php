<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up() : void{
        Schema::create('users_link_tracker', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('users_link_id')->references('id')->on('users_link')->onDelete('cascade');
            $table->foreignId('base_link_id')->references('id')->on('base_link')->onDelete('cascade');
            $table->foreignId('users_feed_id')->nullable();
            $table->string('identifier');
            $table->string('name');
            $table->string('avatar');
            $table->double('view')->nullable()->default('0');
            $table->double('subscriber')->nullable()->default('0');
            $table->dateTime('joined')->nullable();
            $table->boolean('streaming')->default(false);
            $table->double('concurrent')->nullable()->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void{
        Schema::dropIfExists('users_link_tracker');
    }
};
