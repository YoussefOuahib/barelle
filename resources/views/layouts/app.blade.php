<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link href="{{mix('/css/app.css')}}" type="text/css" rel="stylesheet" />
        <meta name="csrf-token" value="{{ csrf_token() }}"/>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp"
        rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/e5f6d12c80.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.1/nouislider.min.css" />
       @yield('styles')
    </head>
    <!--
   if (Auth::check())
        <script>
           window.Laravel = {!json_encode([
               'isLoggedin' => true,
               'user' => Auth::user()
           ])!!}
        </script>
        if(Auth::user()->isAdmin())
        <script>
             window.Laravel = {!json_encode([
               'isAdmin' => true,
               'isLoggedin' => true,
               'user' => Auth::user()
               
           ])!!}
        </script>
        endif
    else
        <script>
            window.Laravel = {!json_encode([
                'isLoggedin' => false
            ])!!}
        </script>
    endif
    -->
    
    <body class="antialiased">
   
        <div id="app">
     
            
        </div>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{mix('/js/app.js')}}"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" ></script>>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.1/nouislider.min.js"></script>


    </body>
</html>