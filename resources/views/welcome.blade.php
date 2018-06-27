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
        <link rel="stylesheet" type="text/css" href="{{asset('./css/app.css')}}">
    </head>
    <body>
        <div id="app">
            <div class="container">
                <mainpage></mainpage>
            </div>
        </div>
    </body>
        <script src="{{asset('./js/app.js')}}"></script>
</html>
