<?php

namespace App\Http\Controllers;

use App\Models\Top40Song;
use Illuminate\Http\Request;

class Top40Controller extends Controller
{
    public function index()
    {
        $top40 = Top40Song::orderBy('position')->get();
        return view('pages.top40.index', compact('top40'));
    }

    public function getTop5AndNewEntries()
    {
        $top5 = Top40Song::orderBy('position')->take(5)->get();
        $newEntries = Top40Song::where('is_new', true)->take(3)->get();
        return ['top5' => $top5, 'newEntries' => $newEntries];
    }
}
