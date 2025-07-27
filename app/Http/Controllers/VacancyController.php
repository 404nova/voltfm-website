<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    public function index()
    {
        $vacancies = Vacancy::where('is_active', true)->latest()->get();
        return view('pages.vacatures.index', compact('vacancies'));
    }

    public function show(Vacancy $vacancy)
    {
        return view('pages.vacatures.show', compact('vacancy'));
    }
}

