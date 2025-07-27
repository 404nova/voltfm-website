<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vacature;
use Illuminate\Http\Request;

class ApplyController extends Controller
{
    public function index()
    {
        $sollicitaties = Vacature::orderBy('applied_at', 'desc')->paginate(20);
        return view('admin.sollicitaties.index', compact('sollicitaties'));
    }

    public function show(Vacature $vacature)
    {
        return view('admin.sollicitaties.view', compact('vacature'));
    }
	public function destroy(Vacature $vacature)
{
    $vacature->delete();

    return redirect()->route('admin.sollicitaties.index')
                     ->with('success', 'Sollicitatie succesvol verwijderd.');
}

}
