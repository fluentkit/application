<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>
        <link rel="stylesheet" href="{{ mix('/css/admin/admin.css') }}" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i&display=swap" />
    </head>
    <body>
        <div id="admin"></div>

        <script>
            window.fkAdminConfig = @json($admin)
        </script>
        <script src="{{ mix('/js/admin/manifest.js') }}"></script>
        <script src="{{ mix('/js/admin/vendor.js') }}"></script>
        <script src="{{ mix('/js/admin/admin.js') }}"></script>
        <script>
            window.fkAdmin.$mount('#admin');
        </script>
    </body>
</html>
