<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up() : void{
        Schema::create('base_proxy_host', function (Blueprint $table) {
            $table->id();
            $table->foreignId('base_proxy_type_id')->references('id')->on('base_proxy_type')->onDelete('cascade');
            $table->boolean('online')->default(false);
            $table->string('host');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void{
        Schema::dropIfExists('base_proxy_host');
    }
};
