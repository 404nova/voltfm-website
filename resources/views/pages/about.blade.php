@extends('layouts.app')

@section('title', 'Over Ons || VoltFM')

@section('content')
<div class="aximo-breadcrumb">
    <div class="container">
        <h1 class="post__title">Over VOLT!</h1>
        <nav class="breadcrumbs">
            <ul>
                <li><a href="/">Home</a></li>
                <li aria-current="page"> Over VOLT!</li>
            </ul>
        </nav>

    </div>
</div>
<!-- End breadcrumb -->


<div class="section aximo-section-padding3">
    <div class="container">
        <div class="aximo-section-title center title-description">
            <h2>
          <span class="aximo-title-animation">
          Ontdek VOLT!
          <span class="aximo-title-icon">
            <img src="assets/images/v1/star2.png" alt="">
          </span>
          </span>
            </h2>
            <p>Welkom bij VOLT! FM – dé jongerenzender met de nieuwste hits, dikke beats en non-stop entertainment! Of je nu onderweg bent, chillt of studeert, wij zorgen voor de juiste vibe.</p>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="aximo-story-thumb wow fadeInUpX" data-wow-delay="0.1s">
                    <img src="{{ asset('assets/images/about/story1.png') }}" alt="">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="aximo-story-thumb wow fadeInUpX" data-wow-delay="0.2s">
                    <img src="{{ asset('assets/images/about/story2.png') }}" alt="">
                </div>
            </div>
        </div>

        <div class="aximo-story-content">
            <div class="row">
                <div class="col-lg-6">
                    <h3>Wat is VOLT?</h3>
                    <p>VOLT! FM is meer dan een radiozender – het is dé plek waar muziek en jongeren samenkomen! Wij brengen de heetste tracks, de leukste shows en de vetste vibes, altijd met de energie die jij zoekt.</p>
                    <p>Of je nu fan bent van pop, hip-hop, dance of de nieuwste viral hits—VOLT! FM houdt je altijd up-to-date. Via onze socials, live shows en interactieve acties bepaal jij mee wat er gebeurt. Dit is jouw station, jouw muziek, jouw VOLT!</p>
                </div>
                <div class="col-lg-6">
                    <h3>Onze missie</h3>
                    <p>Bij VOLT! FM geloven we in de kracht van muziek om jongeren te verbinden, inspireren en energie te geven. Wij willen een platform creëren waar iedereen zich gehoord voelt, waar nieuwe artiesten een podium krijgen en waar luisteraars samen de sound van morgen bepalen.</p>
                    <p>Onze missie is om meer te zijn dan alleen een radiozender. We brengen muziek, entertainment en actualiteit samen op een manier die past bij de belevingswereld van jongeren. Of het nu via de radio, online of op social media is — <b>VOLT! FM is altijd aan!</b></p>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- End section -->

@endsection
