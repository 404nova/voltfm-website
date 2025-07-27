<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SongRequest;
use Illuminate\Http\Request;

class SongRequestController extends Controller
{
    /**
     * Display a listing of the song requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        
        $query = SongRequest::query()->orderBy('created_at', 'desc');
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $songRequests = $query->paginate(15);
        
        // Counts for each status
        $counts = [
            'all' => SongRequest::count(),
            'pending' => SongRequest::pending()->count(),
            'approved' => SongRequest::approved()->count(),
            'rejected' => SongRequest::rejected()->count(),
            'played' => SongRequest::played()->count(),
        ];
        
        return view('admin.song-requests.index', compact('songRequests', 'status', 'counts'));
    }
    
    /**
     * Update the status of a song request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,played'
        ]);
        
        $songRequest = SongRequest::findOrFail($id);
        $songRequest->status = $request->status;
        
        if ($request->status === 'played') {
            $songRequest->played_at = now();
        }
        
        $songRequest->save();
        
        return redirect()->back()->with('success', 'Status van verzoeknummer is bijgewerkt.');
    }
    
    /**
     * Remove the specified song request from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $songRequest = SongRequest::findOrFail($id);
        $songRequest->delete();
        
        return redirect()->back()->with('success', 'Verzoeknummer is verwijderd.');
    }
}
