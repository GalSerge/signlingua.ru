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
        Schema::create('topic_word', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('word_id')->unsigned();
            $table->unsignedBiginteger('topic_id')->unsigned();

            $table->foreign('word_id')->references('id')
                ->on('words')->onDelete('cascade');
            $table->foreign('topic_id')->references('id')
                ->on('topics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_topic');
    }
};
