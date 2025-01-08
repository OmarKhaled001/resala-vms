<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets') }}/favicon.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets') }}/css/perfect-scrollbar.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets') }}/css/style.css" />
    <link defer rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets') }}/css/animate.css" />
    <script src="{{ asset('assets') }}/js/perfect-scrollbar.min.js"></script>
    <script defer src="{{ asset('assets') }}/js/popper.min.js"></script>
    <script defer src="{{ asset('assets') }}/js/tippy-bundle.umd.min.js"></script>
    <script defer src="{{ asset('assets') }}/js/sweetalert.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,700" rel="stylesheet">
    <style>
      * :not(.mdi):not(.angle):not(.las):not(.fe):not(.bx){
            font-family: 'Cairo', sans-serif !important;
        }
        .fl-wrapper{
            z-index: 999 !important;
        }
    </style>

</head>