<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProxyController extends Controller
{
    public function handleRequest(Request $request, $service)
    {
        // Map the service to the actual service URLs
        $services = [
            'payment' => env('PAYMENT_SERVICE_URL')
        ];

        if (!isset($services[$service])) {
            return response()->json(['error' => 'Service not found'], 404);
        }

        // Prepare the full URL for the proxied request
        $url = $services[$service] . str_replace("api", "", $request->path());

        // Forward the request with headers and body
        $response = Http::withHeaders($request->headers->all())
            ->send($request->method(), $url, [
                'query' => $request->query(),
                'json' => $request->json()->all(),
            ]);
        // Return the proxied response to the client
        return response()->json($response->json(), $response->status());
    }
}
