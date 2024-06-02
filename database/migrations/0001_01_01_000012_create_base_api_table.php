<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up() : void{
        Schema::create('base_api', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('base_link_id')->references('id')->on('base_link')->onDelete('cascade');
            $table->string('client_id')->nullable();
            $table->string('client_key')->nullable();
            $table->string('client_secret')->nullable();
            $table->string('bearer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void{
        Schema::dropIfExists('base_api');
    }
};
