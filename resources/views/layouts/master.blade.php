<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>LaraLab</title>

  {{-- importazione di flowbite --}}
  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
   @vite('resources/css/app.css')

</head>
<body>
  <header>
    @include('/partials/navbar')
  </header>
  <body>
    <div>
      @yield('component')
    </div>
  </body>
  <footer>

  </footer>
</body>
</html>