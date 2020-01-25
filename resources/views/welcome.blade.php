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
        <div class="flex h-screen">
            <section class="flex-none bg-gray-800">
                <div class="bg-gradient h-16 flex items-center shadow-md">
                    <img class="flex w-10 h-auto ml-3 mr-2" src="http://fluentkit.io/images/master-logo1000x1000-white-trans.png" />
                    <h1 class="flex text-2xl uppercase mr-5">Fluent<strong>Kit</strong></h1>
                </div>
                <ul class="flex flex-col text-gray-300">
                    @foreach([['label' => 'Blog', 'icon' => 'fa-home', 'children' => [['label' => 'Add New']]], ['label' => 'Pages', 'icon' => 'fa-file', 'children' => [['label' => 'Add New']]]] as $menu)
                        <li class="flex flex-col">
                            <a href="#" class="px-5 pt-2 pb-2 hover:bg-gray-900">
                                <i class="fas {{ $menu['icon'] }} mr-2"></i>
                                {{ $menu['label'] }}
                            </a>
                            @if (!empty($menu['children']))
                                <ul class="flex flex-col text-gray-500">
                                    @foreach($menu['children'] as $child)
                                        <li>
                                            <a href="#" class="block pl-12 pr-5 py-1 text-sm hover:bg-gray-900">
                                                {{ $child['label'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </section>
            <section class="flex-grow flex-column bg-gray-200">
                <nav class="flex items-center h-16 px-12 bg-white shadow-md">
                    header
                </nav>
                <div class="flex m-10">
                    <div class="flex-1 bg-white shadow-md rounded p-10 m-4">
                        foo
                    </div>
                    <div class="flex-1 bg-white shadow-md rounded p-10 m-4">
                        bar
                    </div>
                    <div class="flex-1 bg-white shadow-md rounded p-10 m-4">
                        bazzer
                    </div>
                </div>
            </section>
        </div>

        <script src="{{ mix('/js/manifest.js') }}"></script>
        <script src="{{ mix('/js/vendor.js') }}"></script>
        <script src="{{ mix('/js/admin.js') }}"></script>
    </body>
</html>
