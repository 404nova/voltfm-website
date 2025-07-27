<?php

namespace App\Http\Controllers;

use App\Models\Vacature;
use Illuminate\Http\Request;

class VacatureController extends Controller
{
    public function index()
    {
        $vacancies = Vacature::where('is_active', true)->latest()->get();
        return view('vacatures.index', compact('vacancies'));
    }

    public function show(Vacature $vacature)
    {
        return view('vacatures.show', compact('vacature'));
    }

public function apply(Request $request, Vacancy $vacature)
{
    $validated = $request->validate([
        'naam' => 'required|string|max:255',
        'leeftijd' => 'required|integer',
        'motivatie' => 'required|string',
        'ervaring' => 'required|string',
        'email' => 'required|email',
        'discord' => 'required|string',
    ]);

    // Voeg de vacature-id toe aan de sollicitatie
    $validated['vacancy_id'] = $vacature->id;

    // Voeg user_id toe indien ingelogd
    $validated['user_id'] = auth()->id();

    Vacature::create($validated);

    return redirect()->route('vacatures.show', $vacature)->with('success', 'Sollicitatie verzonden!');
}

	public function destroy(Vacature $sollicitatie)
{
    $sollicitatie->delete();

    return redirect()->route('sollicitaties.index')->with('success', 'Sollicitatie verwijderd.');
}

}

