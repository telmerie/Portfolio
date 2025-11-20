<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <body >

         @include('header')

       


        <div class="content article-crud-content">
            <div>
                @yield('content')
            </div>

            <div>
                @include('categories')
            </div>
           
            
        </div>

        
    </body>
</html>
