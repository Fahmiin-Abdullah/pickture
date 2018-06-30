<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <script>window.Laravel = {csrftoken: '{{csrf_token()}}'}</script>
        <title>Pickture</title>
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="{{asset('./css/app.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('./css/custom.css')}}">
    </head>
    <body>
        <div id="app">
            <navbar></navbar>
            <div class="container90 mt-4">
                <transition name="slider" enter-active-class="animated slideInRight" leave-active-class="animated slideOutLeft" mode="out-in">
                    <router-view id="slider"></router-view>
                </transition>
            </div>
        </div>
    </body>
        <script src="{{asset('./js/app.js')}}"></script>
</html>
