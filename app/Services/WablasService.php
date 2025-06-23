<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WablasService
{
    protected $token;
    protected $secret;
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
        //basically a function to format phone number
        //example +0896123
        //remove + to 0896123
        //replace 0 to 62896123
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        $url = "https://bdg.wablas.com/api/send-message";
        $token = "{$this->token}.{$this->secret}";
        $query = http_build_query([
            'token' => $token,
            'phone' => $phone,
            'message' => $message,
        ]);

        $response = Http::get("$url?$query");

        // Log::info('Wablas Response', [
        //     'request' => "$url?$query",
        //     'status' => $response->status(),
        //     'body' => $response->json(),
        // ]);

        // if (!$response->successful()) {
        //     throw new \Exception('Wablas failed: ' . $response->body());
        // }

        return $response->successful();
    }
}
