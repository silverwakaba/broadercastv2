<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up() : void{
        Schema::create('users_verification', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->nullable()->constrained()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('base_decision_id')->references('id')->on('base_decision')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void{
        Schema::dropIfExists('users_verification');
    }
};
