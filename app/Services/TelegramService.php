<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected $botToken;
    protected $chatId;
    protected $apiUrl;

    public function __construct()
    {
        $this->botToken = '7955493856:AAGqQuY6wo-5VUSRBlgVGqovO3MladC3dTI';
        // Ganti dengan chat ID atau group ID tujuan
        $this->chatId = '-4980842393'; // Contoh: '123456789'
        $this->apiUrl = "https://api.telegram.org/bot{$this->botToken}/sendMessage";
    }

    public function sendNotification($message)
    {
        try {
            $response = Http::post($this->apiUrl, [
                'chat_id' => $this->chatId,
                'text' => $message,
                'parse_mode' => 'HTML'
            ]);

            $responseData = $response->json();
            
            if (!$response->successful()) {
                Log::error('Telegram API Error:', [
                    'status' => $response->status(),
                    'response' => $responseData,
                    'chat_id' => $this->chatId,
                    'message' => $message
                ]);
                return false;
            }

            Log::info('Telegram message sent successfully', [
                'message_id' => $responseData['result']['message_id'] ?? null,
                'chat_id' => $this->chatId
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Telegram notification error: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'chat_id' => $this->chatId,
                'message' => $message
            ]);
            return false;
        }
    }
}
