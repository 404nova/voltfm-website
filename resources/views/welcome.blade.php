<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VOLT!</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@600;700&family=Familjen+Grotesk:wght@600;700&family=Inter:wght@400;600&family=Libre+Baskerville:wght@700&family=Syne:wght@600;700&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-font.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icomoon.css') }}">

    <!-- Code Editor Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">

    <style>
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(195, 241, 53, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(195, 241, 53, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(195, 241, 53, 0);
            }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes badgePulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .simple-player {
            background: rgba(25, 25, 25, 0.85);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .player-main {
            display: flex;
            padding: 20px;
            align-items: center;
        }

        .current-track {
            width: 70px;
            height: 70px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .current-track img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .track-info {
            margin-left: 15px;
            flex-grow: 1;
        }

        .song-title {
            color: white;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
            font-family: 'Syne', sans-serif;
        }

        .song-artist {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            font-family: 'Inter', sans-serif;
        }

        .play-control {
            background: #c3f135;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: none;
            margin-left: 15px;
        }

        .play-control i {
            color: black;
            font-size: 20px;
        }

        .show-info {
            background: rgba(0, 0, 0, 0.2);
            padding: 12px 20px;
            display: flex;
            align-items: center;
        }

        .host-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #c3f135;
        }

        .host-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .host-info {
            margin-left: 12px;
        }

        .live-indicator {
            display: inline-block;
            background: rgba(195, 241, 53, 0.2);
            color: #c3f135;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            padding: 3px 8px;
            border-radius: 4px;
            margin-bottom: 5px;
            font-family: 'Inter', sans-serif;
        }

        .show-title {
            color: white;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Syne', sans-serif;
        }

        /* New volume slider design */
        .volume {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .volume input[type=range] {
            display: none;
        }

        .volume .icon-size {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.5);
        }

        .volume .bar-hoverbox {
            padding: 8px 10px;
            opacity: 0.7;
            transition: opacity .2s;
        }

        .volume .bar-hoverbox:hover {
            opacity: 1;
            cursor: pointer;
        }

        .volume .bar {
            background: #444;
            height: 5px;
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
            pointer-events: none;
        }

        .volume .bar .bar-fill {
            background: #c3f135;
            width: 80%;
            height: 100%;
            background-clip: border-box;
            pointer-events: none;
            transition: width 0.1s ease;
        }

        /* New modern volume control styling */
        .volume-control {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 12px;
            height: 40px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }

        .volume-button {
            background: none;
            border: none;
            cursor: pointer;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.6);
            transition: color 0.2s;
            padding: 0;
        }

        .volume-button:hover {
            color: #c3f135;
        }

        .volume-button i {
            font-size: 16px;
        }

        .volume-segments {
            display: flex;
            align-items: flex-end;
            gap: 3px;
            flex-grow: 1;
            margin: 0 10px;
            height: 25px;
        }

        .segment {
            width: 5px;
            background: rgba(70, 70, 70, 0.5);
            border-radius: 2px;
            cursor: pointer;
            transition: all 0.2s ease;
            flex-grow: 1;
        }

        .segment:hover {
            background: rgba(100, 100, 100, 0.7);
        }

        .segment.active {
            background: #c3f135;
        }

        .segment-1 { height: 4px; }
        .segment-2 { height: 6px; }
        .segment-3 { height: 8px; }
        .segment-4 { height: 10px; }
        .segment-5 { height: 12px; }
        .segment-6 { height: 14px; }
        .segment-7 { height: 16px; }
        .segment-8 { height: 18px; }
        .segment-9 { height: 20px; }
        .segment-10 { height: 22px; }

        .volume-label {
            color: rgba(255,255,255,0.6);
            font-size: 11px;
            font-family: 'Inter', sans-serif;
            min-width: 28px;
            text-align: center;
        }

        /* New card/badge styling */
        .audio-badge {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            background: rgba(20, 20, 20, 0.7);
            border-radius: 30px;
            height: 36px;
            margin-left: 10px;
            min-width: 80px;
            justify-content: center;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .audio-badge:hover {
            background: rgba(30, 30, 30, 0.9);
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        .audio-badge .badge-icon {
            color: #1DB954;
            font-size: 14px;
            margin-right: 6px;
            transition: all 0.3s ease;
        }

        .audio-badge .badge-text {
            color: #fff;
            font-size: 12px;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            white-space: nowrap;
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="light">

<div class="aximo-preloader-wrap">
    <div class="aximo-preloader">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>




<header class="site-header aximo-header-section aximo-header1" id="sticky-menu" style="background: transparent; position: absolute; width: 100%; z-index: 100;">
    <div class="container">
        <nav class="navbar site-navbar">
            <!-- Brand Logo-->
            <div class="brand-logo">
                <a href="/">
                    <img src="assets/images/white.png" alt="" height="50px" class="light-version-logo">
                </a>
            </div>
            <div class="menu-block-wrapper">
                <div class="menu-overlay"></div>
                <nav class="menu-block" id="append-menu-header">
                    <div class="mobile-menu-head">
                        <div class="go-back">
                            <i class="fa fa-angle-left"></i>
                        </div>
                        <div class="current-menu-title"></div>
                        <div class="mobile-menu-close">&times;</div>
                    </div>
                    <ul class="site-menu-main">
                        <li class="nav-item nav-item-has-children">
                            <a href="/" class="nav-link-item drop-trigger">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="/nl/programmering" class="nav-link-item">Programmering</a>
                        </li>
                        <li class="nav-item nav-item-has-children">
                            <a href="/nl/nieuws" class="nav-link-item drop-trigger">Nieuws</a>
                        </li>
                        <li class="nav-item">
                            <a href="/nl/over-ons" class="nav-link-item">Over VOLT!</a>
                        </li>
                        <li class="nav-item">
                            <a href="/vacatures" class="nav-link-item">Vacatures</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="header-btn header-btn-l1 ms-auto d-none d-xs-inline-flex">
                @auth
                <div class="dropdown">
                    <button class="aximo-default-btn pill aximo-header-btn dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="userMenu">
                        <li><a class="dropdown-item" href="/dashboard">Dashboard</a></li>
-                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Uitloggen</button>
                            </form>
                        </li>
                    </ul>
                </div>
                @else
                <a class="aximo-default-btn pill aximo-header-btn" href="/inloggen">
                    Mijn VOLT!
                </a>
                @endauth
            </div>
            <!-- mobile menu trigger -->
            <div class="mobile-menu-trigger light">
                <span></span>
            </div>
            <!--/.Mobile Menu Hamburger Ends-->
        </nav>
    </div>
</header>
<!--End landex-header-section -->



<div class="aximo-hero-section dark-bg" style="background-image: url('https://images.unsplash.com/photo-1741800459656-4116dcb230ae?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center; position: relative; padding-top: 150px;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.7);"></div>
    <div class="container position-relative">
        <div class="row">
            <div class="col-lg-7">
                <div class="aximo-hero-content">
                    <h1>
              <span class="aximo-title-animation">
                Start je dag
              </span>
                        met <b>VOLT!</b>
                    </h1>
                    <p>VOLT is dé internetradio voor jongeren, boordevol energie, de nieuwste muziek en de heetste topics! Van opzwepende beats tot inspirerende verhalen – wij brengen jouw dag op gang met non-stop entertainment. Stem af, voel de vibe en laat je dag knallen met VOLT!</p>

                    <a class="aximo-call-btn" href="#" data-bs-toggle="modal" data-bs-target="#songRequestModal">Verzoek nummertje?<I class="icon-arrow-right"></I></a>
                    <div class="aximo-hero-shape">
                        <img src="assets/images/v1/shape1.png" alt="">
                    </div>
                </div>
            </div>

            <!-- Radio Player Column - Met extra technische sectie voor opvulling -->
            <div class="col-lg-5">
                <div class="simple-player mt-4" style="background: rgba(25, 25, 25, 0.85);">
                    <!-- Verbeterde Show-info sectie -->
                    <div class="show-info" style="background: rgba(0, 0, 0, 0.2); padding: 16px 20px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.05);">
                        @php
                        // Gebruik expliciet de tijdzone
                        $now = \Carbon\Carbon::now('Europe/Amsterdam');
                        $currentDayName = strtolower($now->englishDayOfWeek);
                        $currentTime = $now->format('H:i:s');

                        // Zoek de huidige live show of de eerstvolgende show
                        $liveShow = null;
                        $nextShow = null;

                        if(isset($upcomingShows) && $upcomingShows->count() > 0) {
                        foreach($upcomingShows as $show) {
                        $programDays = collect($show->days)->map(function($day) {
                        return strtolower($day);
                        })->toArray();

                        $isLiveNow = ($currentTime >= $show->time_start && $currentTime < $show->time_end && in_array($currentDayName, $programDays));

                        if($isLiveNow) {
                        $liveShow = $show;
                        break;
                        }

                        // Als we nog geen eerstvolgende show hebben, sla deze op
                        if(!$nextShow && $show->time_start > $currentTime && in_array($currentDayName, $programDays)) {
                        $nextShow = $show;
                        }
                        }

                        // Als we geen live show hebben, gebruik de eerstvolgende of de eerste show in de lijst
                        if(!$liveShow && !$nextShow && $upcomingShows->count() > 0) {
                        $nextShow = $upcomingShows->first();
                        }
                        }

                        // Gebruik de gevonden show (live of eerstvolgende)
                        $currentShow = $liveShow ?? $nextShow;
                        @endphp

                        @if($currentShow)
                        <div style="display: flex; align-items: center;">
                            <div>
                                <div style="font-size: 15px; font-weight: 600; color: white; font-family: 'Syne', sans-serif; letter-spacing: 0.3px;">{{ $currentShow->title }}</div>
                                <div style="font-size: 12px; color: rgba(255,255,255,0.6); font-family: 'Inter', sans-serif; margin-top: 2px;">
                                    @php
                                    $dayNames = collect($currentShow->days)->map(function($day) {
                                    return ucfirst($day);
                                    })->join(', ');

                                    if(count($currentShow->days) > 2) {
                                    $dayNames = 'Weekdagen';
                                    }
                                    @endphp
                                    {{ $dayNames }} • {{ \Carbon\Carbon::parse($currentShow->time_start)->format('H:i') }}-{{ \Carbon\Carbon::parse($currentShow->time_end)->format('H:i') }}
                                </div>
                            </div>
                        </div>

                        <div class="live-indicator" style="display: flex; align-items: center; background: rgba(0,0,0,0.3); border-radius: 20px; padding: 6px 12px; border: 1px solid {{ $liveShow ? 'rgba(195, 241, 53, 0.3)' : 'rgba(255, 255, 255, 0.2)' }};">
                            @if($liveShow)
                            <span style="width: 8px; height: 8px; background: #c3f135; border-radius: 50%; margin-right: 6px; animation: pulse 1.5s infinite;"></span>
                            <span style="color: #c3f135; font-size: 11px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; font-family: 'Inter', sans-serif;">LIVE</span>
                            @else
                            <span style="width: 8px; height: 8px; background: #ff8a3d; border-radius: 50%; margin-right: 6px;"></span>
                            <span style="color: #ff8a3d; font-size: 11px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; font-family: 'Inter', sans-serif;">BINNENKORT</span>
                            @endif
                        </div>
                        @else
                        <div style="display: flex; align-items: center;">
                            <div>
                                <div style="font-size: 15px; font-weight: 600; color: white; font-family: 'Syne', sans-serif; letter-spacing: 0.3px;">VOLT! Radio</div>
                                <div style="font-size: 12px; color: rgba(255,255,255,0.6); font-family: 'Inter', sans-serif; margin-top: 2px;">Doorlopende muziek</div>
                            </div>
                        </div>

                        <div class="live-indicator" style="display: flex; align-items: center; background: rgba(0,0,0,0.3); border-radius: 20px; padding: 6px 12px; border: 1px solid rgba(255, 255, 255, 0.2);">
                            <span style="width: 8px; height: 8px; background: #c3f135; border-radius: 50%; margin-right: 6px; animation: pulse 1.5s infinite;"></span>
                            <span style="color: #c3f135; font-size: 11px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; font-family: 'Inter', sans-serif;">LIVE</span>
                        </div>
                        @endif
                    </div>

                    <div class="player-main" style="background: rgba(25, 25, 25, 0.85);">
                        <div class="current-track">
                            <img src="https://www.top40.nl/media/cache/related/uploads/subtitle/42095_50998/original.jpg" alt="Current track" id="trackImage">
                            <div class="loading-overlay" id="loadingOverlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); display: flex; justify-content: center; align-items: center; display: none;">
                                <div style="width: 30px; height: 30px; border: 3px solid rgba(255,255,255,0.3); border-radius: 50%; border-top-color: #c3f135; animation: spin 1s linear infinite;"></div>
                            </div>
                        </div>
                        <div class="track-info">
                            <div class="song-title" id="songTitle">Laden...</div>
                            <div class="song-artist" id="songArtist">Even geduld</div>
                        </div>

                        <div style="display: flex; align-items: center; margin-left: auto; position: relative;">
                            <button class="play-control" id="playButton" style="background: #c3f135; box-shadow: 0 4px 10px rgba(195, 241, 53, 0.3);">
                                <i class="fa fa-play" id="playIcon" style="color: black;"></i>
                            </button>
                        </div>

                        <!-- Hidden audio element for the radio stream -->
                        <audio id="radioPlayer" style="display: none;" preload="auto">
                            <source src="https://beheer.voltfm.nl:8000/radio.mp3" type="audio/mp3">
                            Je browser ondersteunt geen audio element.
                        </audio>
                    </div>

                    <!-- Volume control indicator visible on the UI -->
                    <div style="padding: 0 20px 3px; display: flex; align-items: center; background: rgba(25, 25, 25, 0.85);">
                        <div style="display: flex; align-items: center; width: 100%; justify-content: space-between;">
                            <div class="volume-control">
                                <input type="range" id="volumeSlider" min="0" max="1" step="0.1" value="0.8" style="display: none;">
                                <button class="volume-button" id="muteButton">
                                    <i class="fa fa-volume-down" id="volumeIcon"></i>
                                </button>
                                <div class="volume-segments" id="volumeSegments">
                                    <div class="segment segment-1" data-value="0.1"></div>
                                    <div class="segment segment-2" data-value="0.2"></div>
                                    <div class="segment segment-3" data-value="0.3"></div>
                                    <div class="segment segment-4" data-value="0.4"></div>
                                    <div class="segment segment-5" data-value="0.5"></div>
                                    <div class="segment segment-6" data-value="0.6"></div>
                                    <div class="segment segment-7" data-value="0.7"></div>
                                    <div class="segment segment-8" data-value="0.8"></div>
                                    <div class="segment segment-9" data-value="0.9"></div>
                                    <div class="segment segment-10" data-value="1.0"></div>
                                </div>
                                <div class="volume-label" id="volumeLabel">80%</div>
                            </div>

                            <div style="display: flex; margin-left: auto;">
                                <div class="audio-badge">
                                    <i class="fa fa-headphones badge-icon"></i>
                                    <span class="badge-text">HQ Audio</span>
                                </div>

                                <div class="audio-badge" style="margin-left: 5px;">
                                    <i class="fa fa-users badge-icon" style="color: #5d9cec;"></i>
                                    <span class="badge-text" id="listeners-count">234</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress indicator for current track -->
                    <div style="padding: 0 20px 10px; display: flex; align-items: center; background: rgba(25, 25, 25, 0.85);">
                        <div style="display: flex; flex-direction: column; width: 100%;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                <span id="currentTime" style="color: rgba(255,255,255,0.7); font-size: 12px; font-family: 'Inter', sans-serif;">--:--</span>
                                <span id="duration" style="color: rgba(255,255,255,0.7); font-size: 12px; font-family: 'Inter', sans-serif;">--:--</span>
                            </div>
                            <div style="width: 100%; height: 4px; background: rgba(255,255,255,0.1); border-radius: 2px; overflow: hidden; position: relative;">
                                <div id="progressBar" style="height: 100%; width: 0%; background: #c3f135; border-radius: 2px; transition: width 1s linear;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- DJ Info met dezelfde achtergrond als de player-main sectie -->
                    <div style="padding: 20px; border-top: 1px solid rgba(255,255,255,0.05); background: rgba(25, 25, 25, 0.85);">
                        @if($currentShow)
                        <div style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <div style="width: 60px; height: 60px; border-radius: 50%; overflow: hidden; border: 2px solid #c3f135; margin-right: 15px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);">
                                @if($currentShow->image)
                                <img src="{{ asset('storage/' . $currentShow->image) }}" alt="{{ $currentShow->presenter }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                <img src="{{ asset('assets/images/team/team1.png') }}" alt="{{ $currentShow->presenter }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @endif
                            </div>
                            <div>
                                <h4 style="color: white; font-size: 18px; font-family: 'Syne', sans-serif; margin-bottom: 5px; font-weight: 600;">{{ $currentShow->title }}</h4>
                                <div style="display: flex; align-items: center;">
                                    <span style="color: rgba(255,255,255,0.7); font-size: 13px; font-family: 'Inter', sans-serif;">{{ \Carbon\Carbon::parse($currentShow->time_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($currentShow->time_end)->format('H:i') }}</span>
                                    <span style="margin: 0 8px; color: #c3f135;">•</span>
                                    <span style="color: #c3f135; font-size: 13px; font-weight: 600; font-family: 'Inter', sans-serif;">VOLT! FM</span>
                                </div>
                            </div>
                        </div>

                        <!-- Berichtblok met consistente achtergrond -->
                        <div style="padding: 15px; background: rgba(0, 0, 0, 0.4); border-radius: 8px; border-left: 3px solid #c3f135; margin-top: 5px;">
                            <p style="color: rgba(255,255,255,0.9); font-size: 14px; font-family: 'Inter', sans-serif; line-height: 1.6; font-style: italic; margin-bottom: 0;">
                                "{{ $currentShow->description }}"
                            </p>
                            <div style="margin-top: 10px; color: rgba(255,255,255,0.7); font-size: 13px; font-style: normal; text-align: right; font-family: 'Inter', sans-serif;">- {{ $currentShow->presenter }}</div>
                        </div>
                        @else
                        <div style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <div style="width: 60px; height: 60px; border-radius: 50%; overflow: hidden; border: 2px solid #c3f135; margin-right: 15px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);">
                                <img src="{{ asset('assets/images/team/team1.png') }}" alt="VOLT DJ" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div>
                                <h4 style="color: white; font-size: 18px; font-family: 'Syne', sans-serif; margin-bottom: 5px; font-weight: 600;">VOLT! Radio</h4>
                                <div style="display: flex; align-items: center;">
                                    <span style="color: rgba(255,255,255,0.7); font-size: 13px; font-family: 'Inter', sans-serif;">24/7</span>
                                    <span style="margin: 0 8px; color: #c3f135;">•</span>
                                    <span style="color: #c3f135; font-size: 13px; font-weight: 600; font-family: 'Inter', sans-serif;">VOLT! FM</span>
                                </div>
                            </div>
                        </div>

                        <!-- Berichtblok met consistente achtergrond -->
                        <div style="padding: 15px; background: rgba(0, 0, 0, 0.4); border-radius: 8px; border-left: 3px solid #c3f135; margin-top: 5px;">
                            <p style="color: rgba(255,255,255,0.9); font-size: 14px; font-family: 'Inter', sans-serif; line-height: 1.6; font-style: italic; margin-bottom: 0;">
                                "Altijd de beste muziek, 24 uur per dag, 7 dagen per week. Luister naar VOLT! Radio voor non-stop hits en de nieuwste muziek!"
                            </p>
                        </div>
                        @endif

                        <div style="margin-top: 40px; text-align: right;">
                            <a href="/nl/programmering" style="display: inline-flex; align-items: center; color: #c3f135; font-size: 14px; font-weight: 600; font-family: 'Inter', sans-serif; text-decoration: none; transition: all 0.3s ease;">
                                Bekijk volledig programma
                                <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-left: 8px;">
                                    <path d="M13.5303 6.53033C13.8232 6.23744 13.8232 5.76256 13.5303 5.46967L8.75736 0.696699C8.46447 0.403806 7.98959 0.403806 7.6967 0.696699C7.40381 0.989593 7.40381 1.46447 7.6967 1.75736L11.9393 6L7.6967 10.2426C7.40381 10.5355 7.40381 11.0104 7.6967 11.3033C7.98959 11.5962 8.46447 11.5962 8.75736 11.3033L13.5303 6.53033ZM0 6.75H13V5.25H0V6.75Z" fill="#c3f135"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End section -->

<!-- Upcoming Shows Section -->
<div class="section aximo-section-padding">
    <div class="container">
        <div class="aximo-section-title">
            <div class="row">
                <div class="col-lg-7">
                    <h2>
                        <span class="aximo-title-animation">
                          Opkomende
                        </span><br>
                        Shows
                    </h2>
                </div>
                <div class="col-lg-4 offset-lg-1 d-flex align-items-center">
                    <p>Mis geen enkele show en ontdek wat er binnenkort live te horen is op VOLT!</p>
                </div>
            </div>
        </div>

        <!-- Shows Cards - Verbeterd design -->
        <div class="row">
            @if(isset($upcomingShows) && $upcomingShows->count() > 0)
            @foreach($upcomingShows as $program)
            <div class="col-lg-4">
                <div class="aximo-show-card wow fadeInUpX" data-wow-delay="0.1s" style="position: relative; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05); border: 1px solid rgba(0, 0, 0, 0.05); margin-bottom: 30px;">
                    <!-- Show Header met afbeelding -->
                    <div style="position: relative; height: 180px; overflow: hidden;">
                        @if($program->image)
                        <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                        <img src="{{ asset('assets/images/team/team1.png') }}" alt="{{ $program->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @endif
                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.6));"></div>

                        @php
                        // Gebruik expliciet de tijdzone
                        $now = \Carbon\Carbon::now('Europe/Amsterdam');
                        $currentDayName = strtolower($now->englishDayOfWeek);
                        $currentTime = $now->format('H:i:s');
                        $tomorrow = $now->copy()->addDay();
                        $tomorrowDayName = strtolower($tomorrow->englishDayOfWeek);

                        // Ensure case-insensitive comparison with days array
                        $programDays = collect($program->days)->map(function($day) {
                        return strtolower($day);
                        })->toArray();

                        $isForTomorrow = !in_array($currentDayName, $programDays) && in_array($tomorrowDayName, $programDays);

                        // Eenvoudige string vergelijking voor tijden
                        $isLiveNow = ($currentTime >= $program->time_start && $currentTime < $program->time_end && in_array($currentDayName, $programDays));
                        @endphp

                        @if($isForTomorrow)
                        <span class="weekend-badge" style="position: absolute; top: 15px; right: 15px; background: rgba(0,0,0,0.6); color: white; font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 30px; font-family: 'Inter', sans-serif; z-index: 2;">MORGEN</span>
                        @elseif($isLiveNow)
                        <span class="live-badge" style="position: absolute; top: 15px; right: 15px; background: #ff4747; color: white; font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 30px; font-family: 'Inter', sans-serif; z-index: 2;">NU LIVE</span>
                        @else
                        <span class="today-badge" style="position: absolute; top: 15px; right: 15px; background: #c3f135; color: #000; font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 30px; font-family: 'Inter', sans-serif; z-index: 2;">VANDAAG</span>
                        @endif

                        <div style="position: absolute; bottom: 15px; left: 20px; color: white; z-index: 2;">
                            <h3 class="text-white" style="font-size: 24px; font-weight: 600; margin-bottom: 5px; font-family: 'Syne', sans-serif;">{{ $program->title }}</h3>
                            <div style="display: flex; align-items: center;">
                                <span style="font-size: 14px; font-family: 'Inter', sans-serif;">{{ \Carbon\Carbon::parse($program->time_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($program->time_end)->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Show Content -->
                    <div style="padding: 25px;">
                        <div style="display: flex; align-items: center; margin-bottom: 15px;">
                            <div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden; margin-right: 15px; border: 2px solid #c3f135;">
                                @if($program->image)
                                <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->presenter }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                <img src="{{ asset('assets/images/team/team1.png') }}" alt="{{ $program->presenter }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @endif
                            </div>
                            <div>
                                <span style="display: block; font-size: 14px; color: #666; font-family: 'Inter', sans-serif; margin-bottom: 3px;">Gepresenteerd door</span>
                                <h4 style="font-size: 16px; font-weight: 600; color: #222; font-family: 'Syne', sans-serif; margin: 0;">{{ $program->presenter }}</h4>
                            </div>
                        </div>
                        <p style="color: #666; font-size: 14px; font-family: 'Inter', sans-serif; line-height: 1.6; margin-bottom: 20px;">{{ $program->description }}</p>
                        <a href="/nl/programmering" style="display: inline-flex; align-items: center; color: #222; font-size: 14px; font-weight: 600; font-family: 'Inter', sans-serif; text-decoration: none; transition: all 0.3s ease;">
                            Meer informatie
                            <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-left: 6px;">
                                <path d="M13.5303 6.53033C13.8232 6.23744 13.8232 5.76256 13.5303 5.46967L8.75736 0.696699C8.46447 0.403806 7.98959 0.403806 7.6967 0.696699C7.40381 0.989593 7.40381 1.46447 7.6967 1.75736L11.9393 6L7.6967 10.2426C7.40381 10.5355 7.40381 11.0104 7.6967 11.3033C7.98959 11.5962 8.46447 11.5962 8.75736 11.3033L13.5303 6.53033ZM0 6.75H13V5.25H0V6.75Z" fill="#222"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    Geen aankomende programma's gevonden.
                </div>
            </div>
            @endif
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <a href="/nl/programmering" style="display: inline-flex; align-items: center; background: #c3f135; color: black; font-size: 16px; font-weight: 600; padding: 12px 28px; border-radius: 50px; text-decoration: none; font-family: 'Syne', sans-serif; transition: all 0.3s ease;">
                Bekijk de programmering
                <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-left: 10px;">
                    <path d="M13.5303 6.53033C13.8232 6.23744 13.8232 5.76256 13.5303 5.46967L8.75736 0.696699C8.46447 0.403806 7.98959 0.403806 7.6967 0.696699C7.40381 0.989593 7.40381 1.46447 7.6967 1.75736L11.9393 6L7.6967 10.2426C7.40381 10.5355 7.40381 11.0104 7.6967 11.3033C7.98959 11.5962 8.46447 11.5962 8.75736 11.3033L13.5303 6.53033ZM0 6.75H13V5.25H0V6.75Z" fill="black"/>
                </svg>
            </a>
        </div>
    </div>
</div>
<!-- Einde Opkomende Shows sectie -->

<!-- Rest of the content -->

<div class="section aximo-section-padding3" style="padding-top: 0px; margin-top: -40px;">
    <div class="container">
        <div class="aximo-section-title">
            <div class="row">
                <div class="col-lg-7">
                    <h2>
              <span class="aximo-title-animation">
                Jouw dag
              </span><br>
                        met muziek
                    </h2>
                </div>
                <div class="col-lg-4 offset-lg-1 d-flex align-items-center">
                    <p>Jouw dag, Met muziek is de perfecte manier om je dag te beleven met een muzikale sfeer.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="aximo-video-wrap wow fadeInUpX" data-wow-delay="0s">
                    <img src="assets/images/v1/video-bg.png" alt="">
                    <a class="aximo-video-popup play-btn1 video-init" href="https://player.twitch.tv/?channel=voltfm&parent=voltfm.nl">
                        <img src="assets/images/v1/play-btn.svg" alt="">
                    </a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="aximo-counter-wrap">
                    <div class="aximo-counter-data">
                        <h2 class="aximo-counter-number">464</h2>
                        <p>Aantal nummers in de AutoDJ</p>
                    </div>
                    <div class="aximo-counter-data">
                        <h2 class="aximo-counter-number">Pop</h2>
                        <p>Meest gedraaide genre</p>
                    </div>
                    <div class="aximo-counter-data">
                        <h2 class="aximo-counter-number">Alex</h2>
                        <p>Werknemer van de maand</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End section -->

<div class="section dark-bg aximo-section-padding3">
    <div class="container">
        <div class="aximo-section-title center light">
            <h2>
                De TOP40 van
                <span class="aximo-title-animation">
            VOLT!
            <span class="aximo-title-icon">
              <img src="assets/images/v1/star2.png" alt="">
            </span>
          </span>
            </h2>
        </div>

        <div class="row">
            <!-- Top 10 nummers in een lijst stijl -->
            <div class="col-lg-8 mx-auto">
                <div class="top40-list" style="background: rgba(25, 25, 25, 0.6); border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); margin-bottom: 40px;">
                    @foreach($top40Data['top5'] as $song)
                        <div class="top40-item" style="display: flex; align-items: center; padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.08); {{ $song->position <= 3 ? 'background: rgba(195, 241, 53, 0.05);' : '' }}">
                            <div class="top40-rank" style="font-size: {{ $song->position <= 3 ? '32px' : '24px' }}; font-weight: 700; color: {{ $song->position <= 3 ? '#c3f135' : 'rgba(255,255,255,0.7)' }}; font-family: 'Syne', sans-serif; width: 60px; text-align: center;">
                                {{ $song->position }}
                            </div>
                            <div class="top40-album" style="width: 80px; height: 80px; margin-right: 20px; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.3); position: relative;">
                                <img src="{{ $song->art_url }}" alt="{{ $song->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @if($song->is_new)
                                    <div style="position: absolute; top: 0; right: 0; background: #c3f135; color: black; font-size: 10px; font-weight: 700; padding: 2px 6px; font-family: 'Inter', sans-serif;">NIEUW</div>
                                @endif
                            </div>
                            <div class="top40-info" style="flex-grow: 1;">
                                <h3 style="color: white; font-size: 20px; font-weight: 600; margin-bottom: 5px; font-family: 'Syne', sans-serif;">{{ $song->title }}</h3>
                                <p style="color: rgba(255,255,255,0.7); font-size: 14px; font-family: 'Inter', sans-serif; margin-bottom: 0;">{{ $song->artist }}</p>
                            </div>
                            <div class="top40-trend" style="color: {{ $song->trend_direction === 'up' ? '#c3f135' : ($song->trend_direction === 'down' ? 'rgba(255,255,255,0.5)' : 'rgba(255,255,255,0.7)') }}; font-size: 14px; font-weight: 600; padding: 5px 10px; border-radius: 4px; background: {{ $song->trend_direction === 'up' ? 'rgba(195, 241, 53, 0.1)' : 'rgba(255, 255, 255, 0.1)' }};">
                                @if($song->trend_direction === 'up')
                                    OMHOOG
                                @elseif($song->trend_direction === 'down')
                                    OMLAAG
                                @elseif($song->trend_direction === 'new')
                                    NEW
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Binnenkomers sectie -->
                <div style="text-align: center; margin-bottom: 30px;">
                    <h3 style="color: white; font-size: 24px; font-weight: 600; margin-bottom: 20px; font-family: 'Syne', sans-serif;">
                        Binnenkomers <span style="color: #c3f135; font-size: 28px;">•</span> Deze Week
                    </h3>
                </div>

                <div class="row">
                    @foreach($top40Data['newEntries'] as $newSong)
                        <div class="col-md-4">
                            <div style="background: rgba(25, 25, 25, 0.4); border-radius: 10px; overflow: hidden; margin-bottom: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); position: relative;">
                                <div style="position: absolute; top: 10px; right: 10px; background: #c3f135; color: black; font-size: 12px; font-weight: 700; padding: 3px 8px; border-radius: 4px; font-family: 'Inter', sans-serif;">NIEUW</div>
                                <img src="{{ $newSong->art_url }}" alt="{{ $newSong->title }}" style="width: 100%; height: 180px; object-fit: cover;">
                                <div style="padding: 15px;">
                                    <h4 style="color: white; font-size: 16px; font-weight: 600; margin-bottom: 3px; font-family: 'Syne', sans-serif;">{{ $newSong->title }}</h4>
                                    <p style="color: rgba(255,255,255,0.7); font-size: 13px; font-family: 'Inter', sans-serif; margin-bottom: 0;">{{ $newSong->artist }}</p>
                                    <div style="color: #c3f135; font-size: 12px; font-weight: 600; margin-top: 10px; font-family: 'Inter', sans-serif;">Positie #{{ $newSong->position }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Bekijk de volledige Top40 knop -->
                <div style="text-align: center; margin-top: 30px;">
                    <a href="{{ route('top40') }}" style="display: inline-flex; align-items: center; background: #c3f135; color: black; font-size: 16px; font-weight: 600; padding: 12px 28px; border-radius: 50px; text-decoration: none; font-family: 'Syne', sans-serif; transition: all 0.3s ease;">
                        Bekijk de volledige TOP40
                        <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-left: 10px;">
                            <path d="M13.5303 6.53033C13.8232 6.23744 13.8232 5.76256 13.5303 5.46967L8.75736 0.696699C8.46447 0.403806 7.98959 0.403806 7.6967 0.696699C7.40381 0.989593 7.40381 1.46447 7.6967 1.75736L11.9393 6L7.6967 10.2426C7.40381 10.5355 7.40381 11.0104 7.6967 11.3033C7.98959 11.5962 8.46447 11.5962 8.75736 11.3033L13.5303 6.53033ZM0 6.75H13V5.25H0V6.75Z" fill="black"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End section -->

<div class="section">
    <div class="container">
        <div class="aximo-faq-wrap">
            <div class="row">
                <div class="col-lg-7 d-flex align-items-center">
                    <div class="aximo-default-content">
                        <h2>
                <span class="aximo-title-animation">
                  Wat maakt ons
                  <span class="aximo-title-icon">
                    <img src="assets/images/v1/star2.png" alt="">
                  </span>
                </span>
                            Fantastisch?
                        </h2>
                        <p>VOLT! FM is niet zomaar een radiozender; we bieden een unieke ervaring voor onze luisteraars. Onze passie voor muziek, innovatieve programma's en onmiskenbare sfeer maken ons tot iets bijzonders. Maar wat maakt ons nu écht fantastisch?</p>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="aximo-accordion-wrap wow fadeInUpX" data-wow-delay="0s" id="aximo-accordion">
                        <div class="aximo-accordion-item open">
                            <div class="aximo-accordion-header">
                                <h3>Unieke Muziek</h3>
                            </div>
                            <div class="aximo-accordion-body">
                                <p>We draaien de beste hits en tijdloze klassiekers, altijd met iets voor iedereen.</p>
                            </div>
                        </div>
                        <div class="aximo-accordion-item">
                            <div class="aximo-accordion-header">
                                <h3>Innovatieve Shows</h3>
                            </div>
                            <div class="aximo-accordion-body">
                                <p>Interactieve en verfrissende programma's, altijd met een persoonlijke touch voor onze luisteraars.</p>
                            </div>
                        </div>
                        <div class="aximo-accordion-item">
                            <div class="aximo-accordion-header">
                                <h3>Onvergetelijke Sfeer</h3>
                            </div>
                            <div class="aximo-accordion-body">
                                <p>Van de eerste noot tot de laatste minuut zorgen wij voor een energie die je niet wilt missen!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End section -->

<div class="section aximo-section-padding3">
    <div class="container">
        <div class="aximo-section-title center">
            <h2>
                Recent
                <span class="aximo-title-animation">
            Nieuws
            <span class="aximo-title-icon">
              <img src="assets/images/v1/star2.png" alt="">
            </span>
          </span>
            </h2>
        </div>
        <div class="row">
            @if(count($recentNews) > 0)
                @foreach($recentNews as $index => $article)
                    <div class="col-lg-6">
                        <div class="aximo-blog-card wow fadeInUpX" data-wow-delay="0.{{ $index + 1 }}s" style="background: #fff; border-radius: 12px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); margin-bottom: 30px;">
                            <div style="height: 220px; position: relative; border-top-left-radius: 12px; border-top-right-radius: 12px; overflow: hidden;">
                                @if($article->image)
                                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <img src="{{ asset('assets/images/v1/project' . ($index % 4 + 1) . '.png') }}" alt="{{ $article->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @endif
                                @if($article->category)
                                    <div style="position: absolute; top: 15px; left: 15px; background: #c3f135; color: black; font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 30px; font-family: 'Inter', sans-serif;">{{ strtoupper($article->category->name) }}</div>
                                @endif
                            </div>
                            <div style="padding: 25px;">
                                <div style="display: flex; align-items: center; margin-bottom: 15px;">
                                    <div style="font-size: 13px; color: #666; font-family: 'Inter', sans-serif;">
                                        <i class="icon-calendar" style="margin-right: 5px;"></i> {{ $article->published_at->format('d M Y') }}
                                    </div>
                                    <div style="width: 4px; height: 4px; border-radius: 50%; background: #c3f135; margin: 0 10px;"></div>
                                    <div style="font-size: 13px; color: #666; font-family: 'Inter', sans-serif;">
                                        <i class="icon-user" style="margin-right: 5px;"></i> Door {{ $article->author ? $article->author->name : 'VOLT! Team' }}
                                    </div>
                                </div>
                                <h3 style="font-size: 22px; font-weight: 600; margin-bottom: 15px; font-family: 'Syne', sans-serif;">{{ $article->title }}</h3>
                                <p style="color: #666; font-size: 15px; font-family: 'Inter', sans-serif; line-height: 1.6; margin-bottom: 20px;">{{ Str::limit(strip_tags($article->excerpt ?: $article->content), 150) }}</p>
                                <a href="{{ route('news.show', $article->slug) }}" style="display: inline-flex; align-items: center; color: #222; font-size: 15px; font-weight: 600; font-family: 'Inter', sans-serif; text-decoration: none; transition: all 0.3s ease;">
                                    Lees meer
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-left: 8px;">
                                        <path d="M13.5303 6.53033C13.8232 6.23744 13.8232 5.76256 13.5303 5.46967L8.75736 0.696699C8.46447 0.403806 7.98959 0.403806 7.6967 0.696699C7.40381 0.989593 7.40381 1.46447 7.6967 1.75736L11.9393 6L7.6967 10.2426C7.40381 10.5355 7.40381 11.0104 7.6967 11.3033C7.98959 11.5962 8.46447 11.5962 8.75736 11.3033L13.5303 6.53033ZM0 6.75H13V5.25H0V6.75Z" fill="#222"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center">
                    <p>Geen recente nieuwsberichten gevonden</p>
                </div>
            @endif

            <!-- Bekijk alle nieuws knop -->
            <div class="col-12 text-center" style="margin-top: 20px;">
                <a href="{{ route('news') }}" style="display: inline-flex; align-items: center; background: #c3f135; color: black; font-size: 16px; font-weight: 600; padding: 12px 28px; border-radius: 50px; text-decoration: none; font-family: 'Syne', sans-serif; transition: all 0.3s ease;">
                    Bekijk al het nieuws
                    <i class="icon-arrow-right" style="margin-left: 8px;"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Footer  -->

<footer class="aximo-footer-section dark-bg">
    <div class="container">
        <div class="aximo-footer-top aximo-section-padding">
            <div class="row">
                <div class="col-lg-7">
                    <div class="aximo-default-content light position-relative">
                        <h2>
                <span class="aximo-title-animation">
                  Jouw energie,

                </span>
                            Jouw sound
                        </h2>
                        <p>VOLT is dé internetradio voor jongeren, boordevol energie, de nieuwste muziek en de heetste topics! Van opzwepende beats tot inspirerende verhalen – wij brengen jouw dag op gang met non-stop entertainment. Stem af, voel de vibe en laat je dag knallen met VOLT!</p>
                        <div class="aximo-info-wrap">
                            <div class="aximo-info">
                                <ul>
                                    <li>Onze licentie:</li>
                                    <li><a href="https://mijnlicentie.nl">80999435</a></li>
                                </ul>
                            </div>
                            <div class="aximo-info">
                                <ul>
                                    <li>Stuur ons een mailtje:</li>
                                    <li><a href="">hallo@voltfm.nl</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="aximo-social-icon social-large">
                            <ul>
                                <li>
                                    <a href="https://discord.gg/voltfm" target="_blank">
                                        <i class="fab fa-discord"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://facebook.com/" target="_blank">
                                        <i class="icon-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/" target="_blank">
                                        <i class="icon-instagram"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/" target="_blank">
                                        <i class="icon-linkedin"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="aximo-hero-shape aximo-footer-shape">
                            <img src="assets/images/v1/shape1.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="aximo-form-wrap">
                        <h4>Stuur ons een berichtje</h4>
                        <form action="#">
                            <div class="aximo-form-field">
                                <input type="text" placeholder="Je naam">
                            </div>
                            <div class="aximo-form-field">
                                <input type="email" placeholder="Je E-Mailadres">
                            </div>
                            <div class="aximo-form-field">
                                <textarea name="textarea" placeholder="Je bericht..."></textarea>
                            </div>
                            <button id="aximo-submit-btn" type="submit">Nu sturen <span><img src="assets/images/icon/arrow-right3.svg" alt=""></span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="aximo-footer-bottom">
            <div class="row">
                <div class="col-lg-12">
                    <div class="aximo-copywright one">
                        <p>2025 &copy; VOLT! FM, een handelsnaam van <a href="https://numblio.com">Numblio</a>. Alle rechten voorbehouden. KvK-Nummer: 95732888</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</footer>





<!-- scripts -->
<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/aos.js') }}"></script>
<script src="{{ asset('assets/js/menu/menu.js') }}"></script>
<script src="{{ asset('assets/js/gsap.min.js') }}"></script>
<script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/countdown.js') }}"></script>
<script src="{{ asset('assets/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/js/SplitText.min.js') }}"></script>
<script src="{{ asset('assets/js/ScrollTrigger.min.js') }}"></script>
<script src="{{ asset('assets/js/ScrollSmoother.min.js') }}"></script>
<script src="{{ asset('assets/js/skill-bar.js') }}"></script>
<!-- <script src="{{ asset('assets/js/scrollsmooth.js') }}"></script> -->
<script src="{{ asset('assets/js/faq.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyArZVfNvjnLNwJZlLJKuOiWHZ6vtQzzb1Y"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>

<!-- Radio Player Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const playButton = document.getElementById('playButton');
    const playIcon = document.getElementById('playIcon');
    const radioPlayer = document.getElementById('radioPlayer');
    const songTitle = document.getElementById('songTitle');
    const songArtist = document.getElementById('songArtist');
    const trackImage = document.getElementById('trackImage');
    const volumeSlider = document.getElementById('volumeSlider');
    const volumeSegments = document.getElementById('volumeSegments');
    const segments = document.querySelectorAll('.segment');
    const volumeLabel = document.getElementById('volumeLabel');
    const volumeIcon = document.getElementById('volumeIcon');
    const muteButton = document.getElementById('muteButton');
    const loadingOverlay = document.getElementById('loadingOverlay');
    const progressBar = document.getElementById('progressBar');
    const currentTimeEl = document.getElementById('currentTime');
    const durationEl = document.getElementById('duration');

    let isPlaying = false;
    let volumeLevel = 0.8; // Default volume level
    let previousVolume = volumeLevel; // Store volume level for mute/unmute
    let currentSongDuration = 0;
    let currentSongElapsed = 0;
    let progressInterval = null;

    // Initialize player
    radioPlayer.volume = volumeLevel;
    volumeSlider.value = volumeLevel;

    // Update segments based on current volume
    updateVolumeSegments(volumeLevel);
    updateVolumeLabel(volumeLevel);
    updateVolumeIcon(volumeLevel);

    // Function to update segments based on volume level
    function updateVolumeSegments(value) {
        const segmentCount = Math.ceil(value * 10);

        segments.forEach((segment, index) => {
            if (index < segmentCount) {
                segment.classList.add('active');
            } else {
                segment.classList.remove('active');
            }
        });
    }

    // Function to update volume label
    function updateVolumeLabel(value) {
        volumeLabel.textContent = Math.round(value * 100) + '%';
    }

    // Function to update volume icon based on volume level
    function updateVolumeIcon(value) {
        volumeIcon.className = 'fa';

        if (value <= 0) {
            volumeIcon.classList.add('fa-volume-off');
        } else if (value <= 0.5) {
            volumeIcon.classList.add('fa-volume-down');
        } else {
            volumeIcon.classList.add('fa-volume-up');
        }
    }

    // Function to update all volume UI elements
    function updateVolumeUI(value) {
        updateVolumeSegments(value);
        updateVolumeLabel(value);
        updateVolumeIcon(value);
        volumeSlider.value = value;
        radioPlayer.volume = value;
    }

    // Handle segment clicks
    volumeSegments.addEventListener('click', function(e) {
        if (e.target.classList.contains('segment')) {
            volumeLevel = parseFloat(e.target.dataset.value);
            updateVolumeUI(volumeLevel);

            // Broadcast volume change to other players
            const volumeChangeEvent = new CustomEvent('volt-volume-change', {
                detail: { volume: volumeLevel }
            });
            document.dispatchEvent(volumeChangeEvent);
        }
    });

    // Handle mute button
    muteButton.addEventListener('click', function() {
        if (volumeLevel > 0) {
            previousVolume = volumeLevel;
            volumeLevel = 0;
        } else {
            volumeLevel = previousVolume;
        }

        updateVolumeUI(volumeLevel);

        // Broadcast volume change
        const volumeChangeEvent = new CustomEvent('volt-volume-change', {
            detail: { volume: volumeLevel }
        });
        document.dispatchEvent(volumeChangeEvent);
    });

    // Volume slider control (hidden but still functional for compatibility)
    volumeSlider.addEventListener('input', function() {
        volumeLevel = parseFloat(this.value);
        updateVolumeUI(volumeLevel);

        // Broadcast volume change to other players
        const volumeChangeEvent = new CustomEvent('volt-volume-change', {
            detail: { volume: volumeLevel }
        });
        document.dispatchEvent(volumeChangeEvent);
    });

    // Listen for volume changes from other players
    document.addEventListener('volt-volume-change', function(e) {
        if (e.detail && typeof e.detail.volume === 'number') {
            volumeLevel = e.detail.volume;
            updateVolumeUI(volumeLevel);
        }
    });

    // Add keyboard shortcuts for volume
    document.addEventListener('keydown', function(event) {
        // Space bar for play/pause
        if (event.code === 'Space' && document.activeElement.tagName !== 'INPUT' &&
            document.activeElement.tagName !== 'TEXTAREA') {
            event.preventDefault();
            playButton.click();
        }

        // Up arrow to increase volume
        if (event.code === 'ArrowUp' && isPlaying) {
            event.preventDefault();
            volumeLevel = Math.min(1, volumeLevel + 0.1);
            updateVolumeUI(volumeLevel);

            // Broadcast volume change
            const volumeChangeEvent = new CustomEvent('volt-volume-change', {
                detail: { volume: volumeLevel }
            });
            document.dispatchEvent(volumeChangeEvent);
        }

        // Down arrow to decrease volume
        if (event.code === 'ArrowDown' && isPlaying) {
            event.preventDefault();
            volumeLevel = Math.max(0, volumeLevel - 0.1);
            updateVolumeUI(volumeLevel);

            // Broadcast volume change
            const volumeChangeEvent = new CustomEvent('volt-volume-change', {
                detail: { volume: volumeLevel }
            });
            document.dispatchEvent(volumeChangeEvent);
        }
    });

    // Format time in MM:SS
    function formatTime(seconds) {
        if (isNaN(seconds) || seconds < 0) return "--:--";
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
    }

    // Update progress bar and time display
    function updateProgress() {
        if (currentSongDuration > 0) {
            // Increase elapsed time if playing
            if (isPlaying) {
                currentSongElapsed = Math.min(currentSongElapsed + 1, currentSongDuration);
            }

            // Calculate and update progress percentage
            const progressPercent = (currentSongElapsed / currentSongDuration) * 100;
            progressBar.style.width = `${progressPercent}%`;

            // Update time displays
            currentTimeEl.textContent = formatTime(currentSongElapsed);
            durationEl.textContent = formatTime(currentSongDuration);
        } else {
            // If we don't have duration info yet, show indeterminate progress
            progressBar.style.width = isPlaying ? '100%' : '0%';
            currentTimeEl.textContent = isPlaying ? "Live" : "--:--";
            durationEl.textContent = "--:--";
        }
    }

    // Loading state handlers
    radioPlayer.addEventListener('waiting', function() {
        loadingOverlay.style.display = 'flex';
    });

    radioPlayer.addEventListener('playing', function() {
        loadingOverlay.style.display = 'none';
    });

    radioPlayer.addEventListener('error', function(e) {
        loadingOverlay.style.display = 'none';
        isPlaying = false;
        playIcon.classList.remove('fa-pause');
        playIcon.classList.add('fa-play');
        console.error('Audio error:', e);
    });

    // Play/Pause functionality
    playButton.addEventListener('click', function() {
        if (isPlaying) {
            radioPlayer.pause();
			radioPlayer.src = "";
			radioPlayer.load();
            playIcon.classList.remove('fa-pause');
            playIcon.classList.add('fa-play');

            // Stop progress tracking
            if (progressInterval) {
                clearInterval(progressInterval);
                progressInterval = null;
            }
        } else {
            loadingOverlay.style.display = 'flex';
			radioPlayer.src = "https://beheer.voltfm.nl:8000/radio.mp3";
			radioPlayer.load();
            radioPlayer.play().then(() => {
                // Start progress tracking
                if (!progressInterval && currentSongDuration > 0) {
                    progressInterval = setInterval(updateProgress, 1000);
                }
            }).catch(error => {
                loadingOverlay.style.display = 'none';
                console.error('Error playing audio:', error);
                songTitle.textContent = 'Kon audio niet afspelen';
                songArtist.textContent = 'Controleer je verbinding';
            });
            playIcon.classList.remove('fa-play');
            playIcon.classList.add('fa-pause');
        }

        isPlaying = !isPlaying;
        updateProgress(); // Update display immediately
    });

    // Function to fetch current track info
    function updateNowPlaying() {
        fetch('https://beheer.voltfm.nl:1443/api/nowplaying')
            .then(response => response.json())
            .then(data => {
                const station = data[0]; // First station is VoltFM - Live

                if (station && station.now_playing && station.now_playing.song) {
                    const currentTrack = station.now_playing.song;

                    // Update track information
                    songTitle.textContent = currentTrack.title || 'Onbekende titel';
                    songArtist.textContent = currentTrack.artist || 'Onbekende artiest';

                    // Update album art if available
                    if (currentTrack.art && currentTrack.art !== '') {
                        trackImage.src = currentTrack.art;
                    } else {
                        // Default image if no art is available
                        trackImage.src = "{{ asset('assets/images/team/team1.png') }}";
                    }

                    // Update duration and progress
                    if (station.now_playing.duration) {
                        currentSongDuration = station.now_playing.duration;
                        currentSongElapsed = station.now_playing.elapsed || 0;

                        // Start progress tracking if not already started
                        if (!progressInterval && isPlaying) {
                            progressInterval = setInterval(updateProgress, 1000);
                        }

                        // Initial progress update
                        updateProgress();
                    }

                    // Also update listeners count from the same response
                    if (station.listeners && station.listeners.current) {
                        updateListenerCount(station.listeners.current);
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching now playing data:', error);
                songTitle.textContent = 'Kon track info niet laden';
                songArtist.textContent = 'Probeer later opnieuw';
            });
    }

    // Update track info initially and every 15 seconds
    updateNowPlaying();
    setInterval(updateNowPlaying, 15000);

    // Apply the slider styling
    const style = document.createElement('style');
    style.textContent = `
        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #c3f135;
            cursor: pointer;
        }
        input[type=range]::-moz-range-thumb {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #c3f135;
            cursor: pointer;
            border: none;
        }
    `;
    document.head.appendChild(style);

    // Get real listeners count from station API
    const listenersCount = document.getElementById('listeners-count');
    let currentListenerCount = 0;

    // Function to update listener count with animation
    function updateListenerCount(count) {
        if (count === currentListenerCount) return;

        // Animate the change
        listenersCount.style.transform = 'scale(1.1)';
        setTimeout(() => {
            listenersCount.textContent = count;
            listenersCount.style.transform = 'scale(1)';
            currentListenerCount = count;
        }, 300);
    }

    // Function to fetch station details with listeners count
    function fetchStationDetails() {
        fetch('https://beheer.voltfm.nl:1443/api/station/1')
            .then(response => response.json())
            .then(data => {
                // If we have mounts with listeners data
                if (data && data.mounts && data.mounts.length > 0) {
                    const defaultMount = data.mounts.find(mount => mount.is_default) || data.mounts[0];

                    if (defaultMount && defaultMount.listeners && defaultMount.listeners.current) {
                        updateListenerCount(defaultMount.listeners.current);
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching station details:', error);
                // Don't update the count if there's an error
            });
    }

    // Initial fetch
    fetchStationDetails();

    // Update every 30 seconds
    setInterval(fetchStationDetails, 30000);
});
</script>

<!-- Voeg dit toe aan het einde van de body, net voor sluit </body> tag -->
<!-- Song Request Modal -->
<div class="modal fade" id="songRequestModal" tabindex="-1" aria-labelledby="songRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none; overflow: hidden;">
            <div class="modal-header" style="background-color: #c3f135; border-bottom: none; padding: 20px 25px;">
                <h5 class="modal-title" id="songRequestModalLabel" style="font-family: 'Syne', sans-serif; font-weight: 700; color: #222;">Verzoeknummer aanvragen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 25px;">
                <form id="songRequestForm">
                    @csrf
                    <div class="alert alert-success" id="songRequestSuccess" style="display: none; border-radius: 10px;">
                        <strong>Bedankt!</strong> Je verzoeknummer is aangevraagd. We zullen het beoordelen en hopelijk binnenkort spelen.
                    </div>
                    <div class="alert alert-danger" id="songRequestError" style="display: none; border-radius: 10px;">
                        <strong>Oeps!</strong> Er is iets misgegaan. Controleer het formulier en probeer het opnieuw.
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label" style="font-family: 'Inter', sans-serif; font-weight: 600; font-size: 14px; color: #444;">Jouw naam*</label>
                        <input type="text" class="form-control" id="name" name="name" required style="border-radius: 10px; border: 1px solid rgba(0,0,0,0.1); padding: 12px 15px; font-family: 'Inter', sans-serif;">
                        <div class="invalid-feedback" id="nameError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label" style="font-family: 'Inter', sans-serif; font-weight: 600; font-size: 14px; color: #444;">E-mailadres (optioneel)</label>
                        <input type="email" class="form-control" id="email" name="email" style="border-radius: 10px; border: 1px solid rgba(0,0,0,0.1); padding: 12px 15px; font-family: 'Inter', sans-serif;">
                        <div class="invalid-feedback" id="emailError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="artist" class="form-label" style="font-family: 'Inter', sans-serif; font-weight: 600; font-size: 14px; color: #444;">Artiest*</label>
                        <input type="text" class="form-control" id="artist" name="artist" required style="border-radius: 10px; border: 1px solid rgba(0,0,0,0.1); padding: 12px 15px; font-family: 'Inter', sans-serif;">
                        <div class="invalid-feedback" id="artistError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="song_title" class="form-label" style="font-family: 'Inter', sans-serif; font-weight: 600; font-size: 14px; color: #444;">Titel van het nummer*</label>
                        <input type="text" class="form-control" id="song_title" name="song_title" required style="border-radius: 10px; border: 1px solid rgba(0,0,0,0.1); padding: 12px 15px; font-family: 'Inter', sans-serif;">
                        <div class="invalid-feedback" id="song_titleError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label" style="font-family: 'Inter', sans-serif; font-weight: 600; font-size: 14px; color: #444;">Bericht (optioneel)</label>
                        <textarea class="form-control" id="message" name="message" rows="3" style="border-radius: 10px; border: 1px solid rgba(0,0,0,0.1); padding: 12px 15px; font-family: 'Inter', sans-serif;"></textarea>
                        <div class="invalid-feedback" id="messageError"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top: none; padding: 0 25px 25px 25px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: #f5f5f5; color: #444; border: none; border-radius: 30px; padding: 10px 20px; font-family: 'Inter', sans-serif; font-weight: 600;">Annuleren</button>
                <button type="button" id="submitSongRequest" class="btn" style="background-color: #c3f135; color: #222; border: none; border-radius: 30px; padding: 10px 20px; font-family: 'Inter', sans-serif; font-weight: 600;">Verzenden</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, setting up song request form handlers');

    // Song Request Form Submission
    const songRequestForm = document.getElementById('songRequestForm');
    const submitButton = document.getElementById('submitSongRequest');

    if (songRequestForm && submitButton) {
        console.log('Found song request form and submit button');

        submitButton.addEventListener('click', function() {
            console.log('Submit button clicked');

            // Reset feedback
            const successEl = document.getElementById('songRequestSuccess');
            const errorEl = document.getElementById('songRequestError');

            if (successEl) successEl.style.display = 'none';
            if (errorEl) errorEl.style.display = 'none';

            // Reset validation errors
            document.querySelectorAll('.invalid-feedback').forEach(el => {
                el.textContent = '';
                el.style.display = 'none';
            });

            // Remove invalid class from all inputs
            document.querySelectorAll('.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });

            // Check form validity
            let isValid = true;
            const requiredFields = songRequestForm.querySelectorAll('input[required]');

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                    const errorEl = document.getElementById(field.id + 'Error');
                    if (errorEl) {
                        errorEl.textContent = 'Dit veld is verplicht';
                        errorEl.style.display = 'block';
                    }
                }
            });

            if (!isValid) {
                console.log('Form validation failed');
                return;
            }

            // Collect form data
            const formData = new FormData(songRequestForm);

            // Debug form data
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }

            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Verzenden...';

            console.log('Sending AJAX request to', '{{ route("api.song-request.store") }}');

            // Basic AJAX with vanilla JS
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route("api.song-request.store") }}', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            xhr.onload = function() {
                console.log('XHR response received', xhr.status);

                // Reset button state
                submitButton.disabled = false;
                submitButton.innerHTML = 'Verzenden';

                try {
                    const response = JSON.parse(xhr.responseText);
                    console.log('Parsed response:', response);

                    if (xhr.status >= 200 && xhr.status < 300) {
                        // Success
                        if (successEl) {
                            successEl.style.display = 'block';
                            successEl.innerHTML = '<strong>Bedankt!</strong> ' + (response.message || 'Je verzoeknummer is aangevraagd.');
                        }

                        // Reset form
                        songRequestForm.reset();

                        // Close modal after delay
                        setTimeout(() => {
                            const modal = bootstrap.Modal.getInstance(document.getElementById('songRequestModal'));
                            if (modal) modal.hide();
                        }, 3000);
                    } else {
                        // Handle validation errors
                        if (errorEl) {
                            errorEl.style.display = 'block';
                            errorEl.innerHTML = '<strong>Fout:</strong> ' + (response.message || 'Er is een fout opgetreden.');
                        }

                        if (response.errors) {
                            Object.keys(response.errors).forEach(key => {
                                const fieldError = document.getElementById(key + 'Error');
                                const field = document.getElementById(key);

                                if (fieldError && field) {
                                    fieldError.textContent = response.errors[key][0];
                                    fieldError.style.display = 'block';
                                    field.classList.add('is-invalid');
                                }
                            });
                        }
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);

                    if (errorEl) {
                        errorEl.style.display = 'block';
                        errorEl.innerHTML = '<strong>Fout:</strong> Er is een onverwachte fout opgetreden.';
                    }
                }
            };

            xhr.onerror = function() {
                console.error('XHR request failed');

                // Reset button state
                submitButton.disabled = false;
                submitButton.innerHTML = 'Verzenden';

                if (errorEl) {
                    errorEl.style.display = 'block';
                    errorEl.innerHTML = '<strong>Fout:</strong> Kan geen verbinding maken met de server.';
                }
            };

            xhr.send(formData);
        });

        // Reset validation on input
        songRequestForm.querySelectorAll('input, textarea').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('is-invalid');
                const errorEl = document.getElementById(this.id + 'Error');
                if (errorEl) {
                    errorEl.textContent = '';
                    errorEl.style.display = 'none';
                }
            });
        });
    } else {
        console.error('Song request form or submit button not found in DOM');
    }
});
</script>

    </body>
    </html>
