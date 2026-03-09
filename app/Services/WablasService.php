<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WablasService
{
    protected $token;
    protected $secret;

    protected $baseUrl = 'https://bdg.wablas.com/api/send-message';
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->token = env('WABLAS_TOKEN');
        $this->secret = env('WABLAS_SECRET');
    }

    public function sendMessage($phone, $message)
        {
            // Sanitize phone number
            $phone = preg_replace('/[^0-9]/', '', $phone);
            if (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }

            $query = http_build_query([
                'token'   => "{$this->token}.{$this->secret}",
                'phone'   => $phone,
                'message' => $message,
            ]);
            $response = Http::get("{$this->baseUrl}?{$query}");
            
            \Log::info('Wablas response:', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return $response->successful();
        }
}