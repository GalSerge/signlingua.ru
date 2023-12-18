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
        Schema::create('constants', function (Blueprint $table) {
            $table->id();
            $table->float('call_amount', 8, 2)->default(0);
            $table->float('trial_amount', 8, 2)->default(10);
            $table->string('feedback_email')->nullable();
            $table->unsignedSmallInteger('repeat_train_v')->default(1);
            $table->unsignedSmallInteger('repeat_train_r')->default(1);
            $table->unsignedSmallInteger('repeat_train_w')->default(1);
        });

        App\Models\Constant::insert(
            [
                [
                    'call_amount' => 0,
                    'trial_amount' => 10,
                ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('constants');
    }
};
