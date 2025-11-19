<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="The Birdwatching Adventure of a Lifetime in Madagascar. Discover unique bird species from around the world through our specialized tours.">
        <meta name="keywords" content="momotas, momotas bird, madagascar bird, madagascar birds, birdwatching madagascar">
        <meta property="og:url" content="https://www.momotas-bird.com/" />
        <meta property="og:type" content="website" />
        <meta property="og:image" content="https://www.momotas-bird.com/images/logo.png" />

        <title inertia>Momotas-bird</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue", 'public/favicon.ico'])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
