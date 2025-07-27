<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BaseAdminController extends Controller
{
    /**
     * Check if user is authenticated and redirect if not
     */
    protected function checkAuth()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        return null;
    }
} 