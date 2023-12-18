<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Call;
use App\Enums\CallStatusEnum;

class CallService
{
    public function checkRequestedCall(int $userId): bool
    {
        $call = Call::where('user_id', $userId)
            ->where('status', CallStatusEnum::REQUESTED)
            ->first();

        return (bool)$call;
    }

    public function createCall(int $userId, string $msg): void
    {
        Call::create(
            [
                'user_id' => $userId,
                'msg' => $msg,
                'status' => CallStatusEnum::REQUESTED
            ]
        );
    }

    public function getAllRequestedCall(): \Illuminate\Database\Eloquent\Collection
    {
        return Call::where('status', CallStatusEnum::REQUESTED);
    }

    public function getAllUserCalls(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        return Call::where('user_id', $userId);
    }

    public function satisfyCall(int $callId): void
    {
        Call::where('id', $callId)
            ->update(['status' => CallStatusEnum::SATISFIED]);
    }
}
