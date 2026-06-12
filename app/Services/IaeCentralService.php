<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class IaeCentralService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = env('IAE_CENTRAL_URL');
        $this->apiKey = env('IAE_API_KEY');
    }

    public function getM2mToken()
    {
        $response = Http::post($this->baseUrl . '/api/v1/auth/token', [
            'api_key' => $this->apiKey
        ]);

        if ($response->successful()) {
            return $response->json('token');
        }

        throw new Exception('Gagal mendapatkan token M2M dari SSO IAE Central');
    }

    public function sendAudit($activityName, $logData)
    {
        $token = $this->getM2mToken();

        $jsonData = json_encode($logData);

        $xmlBody = '<?xml version="1.0" encoding="UTF-8"?>
        <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:iae="http://iae.central/audit">
        <soap:Body>
        <iae:AuditRequest>
        <iae:TeamID>TEAM-03</iae:TeamID>
        <iae:ActivityName>' . $activityName . '</iae:ActivityName>
        <iae:LogContent><![CDATA[' . $jsonData . ']]></iae:LogContent>
        </iae:AuditRequest>
        </soap:Body>
        </soap:Envelope>';

        $response = Http::withToken($token)
            ->withBody($xmlBody, 'text/xml')
            ->post($this->baseUrl . '/soap/v1/audit');

        return $response->body();
    }

    public function publishEvent($payload)
    {
        $token = $this->getM2mToken();

        $response = Http::withToken($token)
            ->post($this->baseUrl . '/api/v1/messages/publish', $payload);

        return $response->json();
    }
}