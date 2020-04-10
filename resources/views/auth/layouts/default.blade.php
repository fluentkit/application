<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>
        <link rel="stylesheet" href="{{ mix('/css/auth/auth.css') }}" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i&display=swap" />
    </head>
    <body>
        <div id="auth"></div>

        <script>
            window.fkAuthConfig = @json(['assetUrl' => asset('/')])
        </script>
        <script src="{{ mix('/js/auth/manifest.js') }}"></script>
        <script src="{{ mix('/js/auth/vendor.js') }}"></script>
        <script src="{{ mix('/js/auth/auth.js') }}"></script>
        <script>
            window.fkAuth.$mount('#auth');
        </script>
    </body>
</html>
