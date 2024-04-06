<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up() : void{
        Schema::create('users_credit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->double('version');
            $table->string('version_name')->nullable();
            $table->string('path_sheet')->nullable();
            $table->string('artist_name')->nullable();
            $table->string('artist_link')->nullable();
            $table->string('rigger_name')->nullable();
            $table->string('rigger_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void{
        Schema::dropIfExists('users_credit');
    }
};
