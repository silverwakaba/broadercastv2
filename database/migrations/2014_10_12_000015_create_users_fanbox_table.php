<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up() : void{
        Schema::create('users_fanbox', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('identifier')->unique();
            $table->boolean('active')->default(false);
            $table->boolean('public')->default(false);
            $table->boolean('attachment')->default(false);
            $table->string('title');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void{
        Schema::dropIfExists('users_fanbox');
    }
};
