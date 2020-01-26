<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>FluentKit</title>
        <link rel="stylesheet" href="{{ mix('/css/admin.css') }}" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i&display=swap" />
    </head>
    <body>
        <div id="admin" class="flex h-screen">
            <section class="flex-none bg-gray-800 h-screen">
                <fk-admin-sidebar-header></fk-admin-sidebar-header>
                <fk-admin-sidebar-menu :sections="sections"></fk-admin-sidebar-menu>
            </section>
            <section class="flex-col bg-gray-200 h-screen w-full overflow-auto pt-16">
                <fk-admin-header></fk-admin-header>
                <div id="progress-container" class="h-10 sticky top-0 left-0 overflow-visible w-full"></div>
                <div id="screen-container" class="flex px-10">
                    <router-view></router-view>
                </div>
            </section>
        </div>

        <script>
            window.fkAdminConfig = @json($admin)
        </script>

        <script src="{{ mix('/js/manifest.js') }}"></script>
        <script src="{{ mix('/js/vendor.js') }}"></script>
        <script src="{{ mix('/js/admin.js') }}"></script>
    </body>
</html>
