<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TO-DO APP</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <style>
        .main-container {
            max-height: 100vh;
            /* или другая высота */
            font-size: 0.80rem !important;
            overflow-y: auto;
        }
    </style>

    <div id="app" class="main-container">
        <app-component></app-component>
    </div>

    <div id="appSecond" class="main-container">
        <app-component></app-component>
    </div>

    <div id="appThird" class="main-container">
        <app-component></app-component>
    </div>

    <script src="{{ mix('js/app.js') }}" defer></script>
</body>

</html>