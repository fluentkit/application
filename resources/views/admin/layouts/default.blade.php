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
            <section class="flex-none bg-gray-800">
                <div class="bg-gradient h-16 flex items-center shadow-md">
                    <img class="flex w-10 h-auto ml-3 mr-2" src="http://fluentkit.io/images/master-logo1000x1000-white-trans.png" />
                    <h1 class="flex text-2xl uppercase mr-5">Fluent<strong>Kit</strong></h1>
                </div>
                <ul class="flex flex-col text-gray-300">
                    <li v-for="section in sections" :key="section.id" :id="'section-'+section.id" class="flex flex-col">
                        <router-link :to="{ name: section.id }" class="px-5 pt-2 pb-2 hover:bg-gray-900">
                            <i class="fas mr-2" :class="section.icon"></i>
                            @{{ section.label }}
                        </router-link>
                        <ul v-if="Object.keys(section.screens).length" class="flex flex-col text-gray-500">
                            <li v-for="screen in section.screens" :key="screen.id" :id="'screen-'+screen.id">
                                <router-link :to="{ name: section.id+'.'+screen.id }" class="block pl-12 pr-5 py-1 text-sm hover:bg-gray-900">
                                    @{{ screen.label }}
                                </router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </section>
            <section class="flex-grow flex-column bg-gray-200">
                <nav class="flex items-center h-16 px-12 bg-white shadow-md">
                    <i v-if="$route.meta.section" class="fas mr-2" :class="$route.meta.section.icon"></i>
                    <span v-for="(title, index) in headerTitles" class="mr-2"><i v-if="index !== 0" class="fas mr-1 fa-chevron-right"></i> @{{ title }}</span>
                </nav>
                <div id="screen-container" class="flex">
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
