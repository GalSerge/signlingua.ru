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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id')->nullable();

            $table->decimal('amount', 10, 2);

            $table->string('description', 255);

            $table->unsignedBigInteger('subscription_id')->nullable();
            $table->foreign('subscription_id')->references('id')
                ->on('subscriptions')->onDelete('cascade');

            $table->unsignedSmallInteger('calls')->default(0);

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->enum('status', ['PENDING', 'WAITING', 'SUCCEEDED', 'CANCELED', 'REFUNDED', 'CANCELED_REFUND'])->default('PENDING');
            $table->enum('type', ['BUYCALL', 'BUYSUB', 'RENEWAL', 'TRIAL'])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};