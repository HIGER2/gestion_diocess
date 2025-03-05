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
        <title>gestion de diocesse</title>
        @vite(['resources/scss/app.scss','resources/js/app.js','resources/css/app.css'])

    </head>
    <body id="app">
        @yield('content')
        <script>

        </script>
    </body>
</html>
