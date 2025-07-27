<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    /**
     * Display a listing of the comments.
     */
    public function index()
    {
        $comments = NewsComment::with('news')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.comments.index', compact('comments'));
    }
    
    /**
     * Display a listing of pending comments.
     */
    public function pending()
    {
        $comments = NewsComment::with('news')
            ->where('approved', false)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.comments.pending', compact('comments'));
    }
    
    /**
     * Approve a comment.
     */
    public function approve(NewsComment $comment)
    {
        $comment->approved = true;
        $comment->save();
        
        Log::info('Comment approved', [
            'comment_id' => $comment->id, 
            'article_id' => $comment->news_id,
            'by_admin' => auth()->id()
        ]);
        
        return redirect()->back()->with('success', 'Reactie succesvol goedgekeurd.');
    }
    
    /**
     * Remove the specified comment.
     */
    public function destroy(NewsComment $comment)
    {
        $commentId = $comment->id;
        $newsId = $comment->news_id;
        
        $comment->delete();
        
        Log::info('Comment deleted', [
            'comment_id' => $commentId, 
            'article_id' => $newsId,
            'by_admin' => auth()->id()
        ]);
        
        return redirect()->back()->with('success', 'Reactie succesvol verwijderd.');
    }
}
