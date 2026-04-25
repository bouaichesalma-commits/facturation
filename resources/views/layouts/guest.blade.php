<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MyApp</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Favicons -->
  <link href="{{ asset('img/SigneMyApp.png') }}" rel="icon">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">

    <style>
        body {
            background: rgb(255, 234, 234)
        }
     
        
      
    </style>

</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-login">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="text-center">
                <a class="text-center" href="/">
                    <img width="250px" class="d-inline mb-2" src="{{asset('img/logo.png')}}" alt="">
                  
                </a>
            </div>
            <div>
                {{ $slot }}
            </div>
           
        </div>
    </div>
    
   
   
</body>

</html>
