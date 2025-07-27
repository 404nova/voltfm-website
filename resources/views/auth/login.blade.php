<!DOCTYPE html>
<html lang="nl">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - VoltFM</title>

  <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">
  <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
  <!--- End favicon-->

  <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@600;700&family=Familjen+Grotesk:wght@600;700&family=Inter:wght@400;600&family=Libre+Baskerville:wght@700&family=Syne:wght@600;700&display=swap" rel="stylesheet">
  <!-- End google font  -->

  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/magnific-popup.css">
  <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
  <link rel="stylesheet" href="assets/css/animate.css">
  <link rel="stylesheet" href="assets/css/custom-font.css">
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/aos.css">
  <link rel="stylesheet" href="assets/css/icomoon.css">

  <!-- Code Editor  -->
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/app.min.css">
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

  <div class="aximo-logo-section">
    <div class="container">
      <a href="{{ url('/') }}">
        <img src="assets/images/white.png" height="50px" alt="VoltFM">
      </a>
    </div>
  </div>
  <!-- end -->

  <div class="section aximo-section-padding">
    <div class="container">
      <div class="aximo-account-title">
        <h2>
          <span class="aximo-title-animation">
          Mijn VOLT!
          </span>
        </h2>
      </div>


        <div class="aximo-account-wrap wow fadeInUpX" data-wow-delay="0.1s">

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif


                <a href="{{ route('sso.redirect') }}" class="aximo-connect-login">
                    <img src="assets/images/google.png" height="50px" alt="">
                    Inloggen met Google
                </a>

                <div class="aximo-account-bottom">
                    <p>Nog geen account? Je account wordt automatisch aangemaakt wanneer je inlogt met Google.</p>
                </div>
        </div>
    </div>
  </div>

  <!-- scripts -->
  <script src="assets/js/jquery-3.6.0.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/aos.js"></script>
  <script src="assets/js/menu/menu.js"></script>
  <script src="assets/js/gsap.min.js"></script>
  <script src="assets/js/isotope.pkgd.min.js"></script>
  <script src="assets/js/jquery.magnific-popup.min.js"></script>
  <script src="assets/js/swiper-bundle.min.js"></script>
  <script src="assets/js/countdown.js"></script>
  <script src="assets/js/wow.min.js"></script>
  <script src="assets/js/SplitText.min.js"></script>
  <script src="assets/js/ScrollTrigger.min.js"></script>
  <script src="assets/js/ScrollSmoother.min.js"></script>
  <script src="assets/js/skill-bar.js"></script>
  <script src="assets/js/app.js"></script>

</body>
</html>
