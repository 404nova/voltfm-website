<?php

namespace App\Http\Controllers;

use App\Models\Vacature;
use App\Models\Vacancy;
use Illuminate\Http\Request;

class VacatureController extends Controller
{
    public function store(Request $request, Vacancy $vacancy)
    {
        $validated = $request->validate([
            'naam' => 'required|string|max:255',
            'leeftijd' => 'required|integer|min:12',
            'ervaring' => 'required|string',
            'motivatie' => 'required|string',
            'email' => 'required|email',
        ]);

        Vacature::create(array_merge($validated, [
            'vacancy_id' => $vacancy->id,
            'discord' => $request->discord
        ]));

        return redirect()->route('vacatures.show', $vacancy)->with('success', 'Sollicitatie verstuurd!');
    }
}


