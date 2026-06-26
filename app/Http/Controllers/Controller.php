<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(version: "1.0.0", title: "Expedition Service API", description: "API Documentation untuk Service C (Ekspedisi/Logistik)")]
#[OA\Server(url: "http://localhost:8000", description: "Local Development Server")]
#[OA\SecurityScheme(securityScheme: "ApiKeyAuth", type: "apiKey", in: "header", name: "X-IAE-KEY")]
abstract class Controller
{
}