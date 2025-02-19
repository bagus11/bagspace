<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bagspace - Pralon</title>
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <link rel="icon" href="{{URL::asset('icon.jpg')}}">
    
    <link rel="stylesheet" type="text/css" href="{{asset('assets/garage/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('assets/garage/css/login.css')}}">
    <style>
           @import url('https://fonts.cdnfonts.com/css/poppins');
        html{
            font-family: Poppins !important ;
        }
        input{
            font-family: Poppins !important ;
        }
        button{
            font-family: Poppins !important ;
            border-radius: 15px !important;
           }
           html {
            position: relative;
            height: 100vh;
            width: 100vw;
        }

        html::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("{{ asset('bg-4.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(8px); /* Apply the blur effect to the background */
            z-index: -1; /* Ensure the blurred background is behind the content */
        }

    </style>
</head>
<body style="background: transparent">
    <div id="app">
        <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
            @yield('content')
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>
