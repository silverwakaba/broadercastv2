<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up() : void{
        Schema::create('base_feed_keyword', function (Blueprint $table) {
            $table->id();
            $table->foreignId('base_feed_type_id')->references('id')->on('base_feed_type')->onDelete('cascade');
            $table->string('name');
            $table->mediumText('keyword');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void{
        Schema::dropIfExists('base_feed_keyword');
    }
};
