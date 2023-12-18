<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('region_word', function (Blueprint $table) {
            $table->id();

            $table->unsignedBiginteger('word_id')->unsigned();
            $table->unsignedBiginteger('region_id')->unsigned();

            $table->foreign('word_id')->references('id')
                ->on('words')->onDelete('cascade');
            $table->foreign('region_id')->references('id')
                ->on('regions')->onDelete('cascade');

            $table->unique(['word_id', 'region_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('region_word');
    }
};
