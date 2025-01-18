<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
        <link rel="icon" type="image/png" sizes="192x192" href="https://static.wixstatic.com/media/0839e4_c29fb678529e45718de0137e59f28557%7Emv2.jpg/v1/fill/w_192%2Ch_192%2Clg_1%2Cusm_0.66_1.00_0.01/0839e4_c29fb678529e45718de0137e59f28557%7Emv2.jpg">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <title>gestion de diocesse</title>
        @vite(['resources/scss/app.scss','resources/js/app.js','resources/css/app.css'])

    </head>
    <body id="app">

        <app-layout :user="{{ json_encode(Auth::user()) }}">
            @yield('content')
        </app-layout>

        <script>

        </script>
    </body>

    <style>
        body{
        font-family: "Poppins", serif;
        font-weight: 400;
        }
    </style>

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <!-- Production version -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
    lucide.createIcons();
  </script>
</html>
