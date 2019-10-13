<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="bootstrap admin template">
        <meta name="author" content="">
        <title>CV - Arie | Percetakan Digital</title>
        <link rel="apple-touch-icon" href="{{ asset('global/assets/images/logo.png') }}">
        <link rel="shortcut icon" href="{{ asset('global/assets/images/logo.png') }}">
        @include('back.layouts.css')
        @section('style') @show 
    </head>
    <body class="dashboard">
        @include('back.layouts.header')
        @include('back.layouts-manajer.sidebar-manajer')
        @yield('body')
        @include('back.layouts.footer')
        @include('back.layouts.js')
        @section('script') @show 
    </body>
</html>