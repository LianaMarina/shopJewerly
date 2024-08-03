<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('public\css\bootstrap.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>@yield('title')</title>
</head>
<body style="background-color: #ebe7dd;">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500&display=swap');
        a {
            font-family: 'Oswald';
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="phone"], input[type="date"]  {
            background-color: #ebe7dd;
            border: 1px solid #686451;
        }
        input:focus {
            background-color: #ebe7dd !important;
            box-shadow: none !important;
            border: 2px solid #686451 !important;
        }
        .form-button {
            background-color: #686451;
            padding: 10px 20px !important;
            color: white;
        }
        .form-button:hover {
            background-color: #6864519e;
            color: white;
        }
        .btn-category:focus {
            background-color: #6864518d !important;
        }
        textarea {
            background-color: #ebe7dd !important;
            border: 1px solid #686451 !important;
        }
        textarea:focus {
            background-color: #ebe7dd !important;
            box-shadow: none !important;
            border: 2px solid #686451 !important;
        }
        select {
            background-color: #ebe7dd !important;
            border: 1px solid #686451 !important;
        }
        select:focus {
            background-color: #ebe7dd !important;
            box-shadow: none !important;
            border: 2px solid #686451 !important;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.3.5/vue.global.js"></script>
    <script src="{{ asset('public\js\bootstrap.bundle.js') }}"></script>
    @include('layout.navbar')
    @yield('content')
    
    
</body>
</html>