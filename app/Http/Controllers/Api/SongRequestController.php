<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SongRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SongRequestController extends Controller
{
    /**
     * Store a new song request via API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        Log::info('API SongRequestController store method called', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'request_data' => $request->all(),
            'headers' => $request->headers->all(),
        ]);

        try {
            // Verzoekgegevens ophalen, afhankelijk van de methode
            $data = $request->method() === 'GET' ? $request->query() : $request->all();

            $validator = Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'artist' => 'required|string|max:255',
                'song_title' => 'required|string|max:255',
                'message' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                Log::warning('API Song request validation failed', ['errors' => $validator->errors()]);

                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $songRequest = SongRequest::create([
                'name' => $data['name'],
                'email' => $data['email'] ?? null,
                'artist' => $data['artist'],
                'song_title' => $data['song_title'],
                'message' => $data['message'] ?? null,
                'status' => 'pending',
            ]);

            Log::info('API Song request created successfully', ['id' => $songRequest->id]);

            return response()->json([
                'success' => true,
                'message' => 'Bedankt voor je verzoeknummer! We zullen het beoordelen en hopelijk binnenkort spelen.',
                'request_id' => $songRequest->id
            ], 201);

        } catch (\Exception $e) {
            Log::error('API Error creating song request', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Er is een onverwachte fout opgetreden bij het verwerken van je verzoek.'
            ], 500);
        }
    }
}
