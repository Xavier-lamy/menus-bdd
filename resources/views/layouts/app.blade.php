<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À la Carte</title>
    <link rel="stylesheet" type="text/css" href={{ asset("assets/css/app.css") }}>
</head>
<body>
    <header class="bg--primary text--light">
        @include("partials.navbar")
    </header>
    @section("wrapper")

    @show
    <footer class="bg--primary text--light">
        <div class="copyright">
            <small>&copy; Copyright 2021 A La Carte</small>
        </div>
    </footer>
    <script src="https://kit.fontawesome.com/0cb3a70ede.js" crossorigin="anonymous"></script>
    <script src="{{ asset("assets/js/script.js") }}"></script>
</body>
</html>