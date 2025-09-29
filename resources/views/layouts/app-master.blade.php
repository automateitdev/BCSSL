<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.admin.partials.style')

    <title>@yield('title', config('app.title'))</title>
 <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

</head>

<body>
    <div class="container mt-5" id="app">
       {{$slot}}
    </div>

    @include('layouts.admin.partials.script')

</body>

</html>
