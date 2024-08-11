<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up() : void{
        Schema::create('users_relation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_follower_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('users_followed_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void{
        Schema::dropIfExists('users_relation');
    }
};
