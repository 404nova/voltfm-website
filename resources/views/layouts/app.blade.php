<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'VoltFM')</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@600;700&family=Familjen+Grotesk:wght@600;700&family=Inter:wght@400;600&family=Libre+Baskerville:wght@700&family=Syne:wght@600;700&display=swap" rel="stylesheet">

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

    @yield('additional_css')
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

<header class="site-header aximo-header-section aximo-header1 dark-bg" id="sticky-menu">
    <div class="container">
        <nav class="navbar site-navbar">
            <!-- Brand Logo-->
            <div class="brand-logo">
                <a href="/">
                    <img src="{{ asset('assets/images/white.png') }}" alt="" height="50px" class="light-version-logo">
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
                        @if(Request::is('dashboard*'))
                            <li class="nav-item">
                                <a href="/dashboard" class="nav-link-item">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a href="/dashboard/top40" class="nav-link-item">Top 40</a>
                            </li>
                            <li class="nav-item">
                                <a href="/dashboard/favorites" class="nav-link-item">Favorieten</a>
                            </li>
                            <li class="nav-item">
                                <a href="/dashboard/points" class="nav-link-item">Punten</a>
                            </li>
                        @else
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
                        @endif
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
                            <li><hr class="dropdown-divider"></li>
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

@yield('content')

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
                                    <a href="https://twitter.com/" target="_blank">
                                        <i class="icon-twitter"></i>
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
<script src="{{ asset('assets/js/faq.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyArZVfNvjnLNwJZlLJKuOiWHZ6vtQzzb1Y"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>

@yield('additional_scripts')

</body>
</html>
