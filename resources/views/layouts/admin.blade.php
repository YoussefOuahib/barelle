<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp"
      rel="stylesheet">
      <!-- site metas -->
      <title>PAPPY</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <script src="https://kit.fontawesome.com/e5f6d12c80.js" crossorigin="anonymous"></script>
    
      <link rel="stylesheet" href="{{mix('css/admin.css')}}">
   </head>
     
   @if (Auth::check())
        <script>
            console.log('logged');
           window.Laravel = {!!json_encode([
               'isLoggedin' => true,
               'user' => Auth::user()
           ])!!}
        </script>
        @if(!Auth::user()->isAdmin())
        <script>
            window.Laravel = {!!json_encode([
              'isAdmin' => null,
              'isLoggedin' => true,
              'user' => Auth::user()
              
          ])!!}
          window.location.href = "/home"
       </script>
     
        @endif
    @else
        <script>
            
           console.log('not logged')
            window.Laravel = {!!json_encode([
                'isLoggedin' => false
            ])!!}
            window.location.href = "/home"
        </script>
    @endif
   <body class="antialiased">
   
    <div id="admin">
 
        
    </div>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="{{mix('/js/admin.js')}}"></script>
</body>

</html>