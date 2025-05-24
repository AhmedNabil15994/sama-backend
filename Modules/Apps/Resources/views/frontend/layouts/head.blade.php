<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') || {{ setting('app_name', locale()) }}</title>
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('frontend') }}/assets/images/favicons/favicon-32x32.png">
    <!-- plugin scripts -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik+Gemstones&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,500i,600,700,800%7CSatisfy&amp;display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/animate.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/plugins/fontawesome-free-5.11.2-web/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/plugins/sama-icons/style.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/magnific-popup.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/vegas.min.css">
    @stack('css')
    <!-- template styles -->
    {{-- <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/style-exam-{{ locale() }}.css"> --}}
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/style-{{ locale() }}.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/responsive.css">

    <!-- Meta Pixel Code -->
  <!-- Meta Pixel Code -->
  <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1439007990289079');
    fbq('track', 'PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none"
                 src="https://www.facebook.com/tr?id=1439007990289079&ev=PageView&noscript=1"
    /></noscript>
  <!-- End Meta Pixel Code -->
    @stack('social_scripts')
  <style>
    .header-navigation .container .navbar-brand img{
      width: 160px !important;
    }
    .select2{
      padding: 10px;
    }
    .select2-container--open{
      width: auto !important;
    }
    .select2-selection{
      border: 0 !important;
      background: transparent !important;
    }
    .select2-container .select2-selection--single .select2-selection__rendered{
      padding-right: 0 !important;
    }
    .select2-selection__arrow{
      top: 10px !important;
      @if(locale() == 'ar')
      left: 0 !important;
      @else
      right: 0 !important;
      @endif
    }
  </style>
</head>

<body>

    @if (!App::environment(['local']))
{{--        <div class="preloader"><span></span></div><!-- /.preloader -->--}}
    @endif
