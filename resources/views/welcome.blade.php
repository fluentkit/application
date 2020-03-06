<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>FluentKit</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i&display=swap" />
    </head>
    <body>
    @todo
    {{ $foo  }}
    @php
    \Illuminate\Support\Facades\View::share('foo', $foo);
    @endphp
    {!! \Illuminate\Support\Facades\Blade::compileString('hello {{ $foo }} me') !!}
    </body>
</html>
