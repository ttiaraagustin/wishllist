<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WishList</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    </head>
  <body>
    @include('layouts.navbar')

    <div class="flex justify-center">
        @yield('body')
    </div>

   </body>
</html>
