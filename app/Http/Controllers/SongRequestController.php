<?php

namespace App\Http\Controllers;

use App\Models\SongRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SongRequestController extends Controller
{
    /**
     * Store a new song request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info('WEB SongRequestController store method called', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'request_data' => $request->all(),
            'headers' => $request->headers->all(),
        ]);
        
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'artist' => 'required|string|max:255',
                'song_title' => 'required|string|max:255',
                'message' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                Log::warning('Song request validation failed', ['errors' => $validator->errors()]);
                
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $songRequest = SongRequest::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'artist' => $request->input('artist'),
                'song_title' => $request->input('song_title'),
                'message' => $request->input('message'),
                'status' => 'pending',
            ]);
            
            Log::info('Song request created successfully', ['id' => $songRequest->id]);

            return response()->json([
                'success' => true,
                'message' => 'Bedankt voor je verzoeknummer! We zullen het beoordelen en hopelijk binnenkort spelen.'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error creating song request', [
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
