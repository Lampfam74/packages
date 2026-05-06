<?php

namespace Lampedev\SecuritySuite\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class AlertService
{
    public function telegram($message)
    {
        Http::post("https://api.telegram.org/bot".config('security.telegram.token')."/sendMessage", [
            'chat_id' => config('security.telegram.chat_id'),
            'text' => $message
        ]);
    }

    public function email($to, $message)
    {
        Mail::raw($message, function ($mail) use ($to) {
            $mail->to($to)->subject("🚨 Security Alert");
        });
    }
}