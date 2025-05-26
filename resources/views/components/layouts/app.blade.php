<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kiosk Display</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @livewireStyles
    @livewireScripts

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('2c345791d572acf0e408', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            alert(JSON.stringify(data));
        });
    </script>
    @livewire('notifications')
    <script>
        window.addEventListener('show-filament-notification', event => {
            if (window.Filament?.notify) {
                window.Filament.notify('success', {
                    title: event.detail.title,
                    message: event.detail.message,
                    icon: 'heroicon-o-shopping-cart',
                    timeout: 5000,
                });
            }
        });
    </script>

</head>

<body>
    <header></header>

    <main>
        {{ $slot }}
    </main>

</body>

</html>
