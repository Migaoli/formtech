<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="/css/formtech.css">

    <title>@yield('page-title', 'Formtech')</title>
</head>
<body class="">

@include('formtech::partials.header')

<div class="">
    @yield('content')
</div>

</body>
</html>
