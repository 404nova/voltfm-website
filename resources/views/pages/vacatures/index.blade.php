@extends('layouts.app')

@section('title', 'Vacatures || VoltFM')

@section('content')
<div class="aximo-breadcrumb">
    <div class="container">
        <h1 class="post__title">Vacatures</h1>
        <nav class="breadcrumbs">
            <ul>
                <li><a href="/">Home</a></li>
                <li aria-current="page">Vacatures</li>
            </ul>
        </nav>
    </div>
</div>

<div class="section aximo-section-padding2">
    <div class="container" style="max-width: 960px;">

        <div class="aximo-section-title center title-description" style="margin-bottom: 40px;">
            <h2 style="font-family: 'Syne', sans-serif; font-weight: 700; font-size: 28px; text-align: center;">
                Werken bij
                <span style="margin-left: 8px; vertical-align: middle;">
                    <img src="{{ asset('assets/images/v1/star2.png') }}" alt="Star" style="height: 24px;">
                </span>
                <br>VOLT! FM
            </h2>
            <p style="color: #ccc; font-family: 'Inter', sans-serif; font-size: 16px; max-width: 600px; margin: 10px auto 0 auto;">
                Wil jij deel uitmaken van het leukste radioteam van Nederland? Bekijk hieronder onze openstaande vacatures of stuur een open sollicitatie!
            </p>
        </div>

        @if($vacancies->isEmpty())
            <div style="background: rgba(255, 255, 255, 0.05); border-radius: 12px; padding: 32px; text-align: center; box-shadow: 0 8px 30px rgba(0,0,0,0.3); color: #eee; font-family: 'Inter', sans-serif;">
                <h4 style="margin-bottom: 8px;">Er zijn op dit moment geen openstaande vacatures.</h4>
                <p>
                    <a style="color: #222;">Stuur gerust een open sollicitatie naar</a>
                    <a href="mailto:bestuur@voltfm.nl" style="color: #c3f135; text-decoration: underline;">bestuur@voltfm.nl</a>
                </p>
            </div>
        @else
            <div style="display: flex; flex-wrap: wrap; gap: 30px; justify-content: center;">
                @foreach($vacancies as $vacancy)
                <a class="vacature-card" href="{{ route('vacatures.show', $vacancy) }}" 
                   style="text-decoration: none; flex: 0 1 calc(33.333% - 20px); background: #fff; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); padding: 25px; 
                          display: flex; flex-direction: column; transition: box-shadow 0.3s ease; color: #222; font-family: 'Inter', sans-serif;">
                    <h4 style="font-family: 'Syne', sans-serif; font-weight: 600; font-size: 18px; margin-bottom: 6px;">
                        {{ strtoupper($vacancy->title) }}
                    </h4>
                    <p style="color: #666; font-style: italic; font-size: 14px; margin-bottom: 15px;">
                        {{ $vacancy->subtitle ?? 'Word jij onze nieuwe collega?' }}
                    </p>
                    
                    <div  style="color: #444; font-size: 14px; margin-bottom: 20px; line-height: 1.4; white-space: pre-line;">
                        {!! Str::limit(strip_tags($vacancy->description), 300, '...') !!}
                    </div>
                    
                    <button>
                        Solliciteer nu!
                    </button>
                    
                    <span style="margin-top: auto; margin-top: 20px; color: #007bff; font-size: 14px; font-weight: 600; font-family: 'Inter', sans-serif;">
                        Meer info →
                    </span>
                </a>
                @endforeach
            </div>
        @endif

    </div>
</div>
<style>
.vacature-card {
    display: flex;
    flex-direction: column;
    min-height: 500px; /* vaste hoogte */
    background: #fff;
    border-radius: 16px;
    border: 1.5px solid #000; /* zwarte rand */
    box-shadow: 0 0 0 2px #222, 0 10px 25px rgba(255, 255, 255, 0.7); /* zwarte rand + witte schaduw */
    padding: 25px;
    font-family: 'Inter', sans-serif;
    color: #222;
    transition: box-shadow 0.3s ease;
}

.vacature-card .vacature-content {
    flex-grow: 1; /* vult de ruimte zodat knop naar onder gedrukt wordt */
    margin-bottom: 20px;
    color: #444;
    font-size: 14px;
    line-height: 1.4;
    white-space: pre-line;
}

.vacature-card button {
    align-self: flex-start;
    margin-top: auto; /* zorgt dat de knop onderaan blijft */
    background-color: #c3f135;
    border: 2px solid #222;
    padding: 10px 24px;
    border-radius: 9999px;
    font-weight: 700;
    color: #222;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
    transition: background-color 0.3s, border-color 0.3s;
}

.vacature-card button:hover {
    background-color: #b3d325;
    border-color: #444;
}



.vacature-card h4 {
    font-family: 'Syne', sans-serif;
    font-weight: 600;
    font-size: 18px;
    margin-bottom: 6px;
}




.vacature-card span {
    margin-top: 12px;
    color: #007bff;
    font-size: 14px;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
}
</style>
@endsection
