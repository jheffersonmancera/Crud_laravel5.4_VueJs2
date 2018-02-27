<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="">

        <title>Laravel & vue</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
       <!-- <link rel="stylesheet" type="text/css" href="plugins/bootstrap.min.css"> -->
         


       
    </head>
    <body>
        <div class="container">
            

                @yield('content') <!-- *1 -->
                

           
        </div>
        <script src="{{asset('js/app.js')}}"></script>
        <!-- <script src=//asset('plugins/js/bootstrap.min.js'}></script> -->
                  
    </body>
</html>
