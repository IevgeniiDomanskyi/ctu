<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>App</title>

        @viteReactRefresh
        @vite('resources/js/index.jsx')
    </head>
    <body>
        <div id="root"></div>
    </body>
</html>
