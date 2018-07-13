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
            <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-dark">
                <div class="container">
                    <a class="navbar-brand text-white" href="/">Pickture</a>
                </div>
            </nav>
            <div class="container90 mt-10">
                <div class="col-md-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <form action="/password/reset" method="POST">
                                @csrf
                                <input type="hidden" name="token" value="{{$token}}">
                                <div class="container">
                                    <h4 class="text-center mb-3">You're almost there!</h4>
                                    <p class="text-center">Please do not leave this page until you have finished resetting your password. Make sure to use your original email but with a different password.</p>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="password_confirmation">Confirm password</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-block btn-success text-white">Reset password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
        <script src="{{asset('./js/app.js')}}"></script>
</html>