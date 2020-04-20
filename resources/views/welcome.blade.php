<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Weather App</title>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/places.js@1.18.1" defer></script>
    <script src="{{ asset('/js/app.js') }}" defer></script>
</head>
<body class="bg-blue-200">

<div id="app" class="flex justify-center pt-16">
    <weather-app></weather-app>
</div>

</body>
</html>
