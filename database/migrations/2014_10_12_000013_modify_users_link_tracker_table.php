<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up() : void{
        Schema::table('users_link_tracker', function (Blueprint $table) {
            $table->after('base_link_id', function (Blueprint $table) {
                $table->foreignId('users_feed_id')->nullable()->constrained()->references('id')->on('users_feed');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void{
        //
    }
};
