<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIaeKey
{
    public function handle(Request $request, Closure $next)
    {
        $nim = env('IAE_NIM', '102022430048');

        if ($request->header('X-IAE-KEY') !== $nim) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized: API Key (NIM) tidak valid atau tidak ditemukan.',
                'errors' => null
            ], 401);
        }
        return $next($request);
    }
}