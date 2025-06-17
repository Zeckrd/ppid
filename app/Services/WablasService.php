<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

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
        $url = "https://wablas.com/api/send-message";
        $response = Http::get($url, [
            'token'   => "{$this->token}.{$this->secret}",
            'phone'   => $phone,
            'message' => $message,
        ]);

        return $response->json();
    }
}
