<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <title>Login Page | Silid Aralan</title>

  <!-- CORE CSS-->
  
    <link href="{{ URL::asset('assets/css/materialize.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="{{ URL::asset('assets/css/style.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="{{ URL::asset('assets/css/custom-style.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="{{ URL::asset('assets/css/page-center.css') }}" type="text/css" rel="stylesheet" media="screen,projection"> 

    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="{{ URL::asset('assets/css/prism.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="{{ URL::asset('assets/js/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
    <style type="text/css">
    h1,h2,h3,h4,h5,h6{
        font-weight: 300;
        /*color: #ffffff;*/
    }
    .card-panel {
        background-color: rgba(255, 255, 255, 0.48);
    }
    input[type=text]:focus:not([readonly]), input[type=password]:focus:not([readonly]), input[type=email]:focus:not([readonly]), input[type=url]:focus:not([readonly]), input[type=time]:focus:not([readonly]), input[type=date]:focus:not([readonly]), input[type=datetime-local]:focus:not([readonly]), input[type=tel]:focus:not([readonly]), input[type=number]:focus:not([readonly]), input[type=search]:focus:not([readonly]), textarea.materialize-textarea:focus:not([readonly]) {
        border-bottom: 1px solid black !important;
        box-shadow: 0 1px 0 0 black !important;
    }

    input[type=text]:focus:not([readonly]) + label, input[type=password]:focus:not([readonly]) + label, input[type=email]:focus:not([readonly]) + label, input[type=url]:focus:not([readonly]) + label, input[type=time]:focus:not([readonly]) + label, input[type=date]:focus:not([readonly]) + label, input[type=datetime-local]:focus:not([readonly]) + label, input[type=tel]:focus:not([readonly]) + label, input[type=number]:focus:not([readonly]) + label, input[type=search]:focus:not([readonly]) + label, textarea.materialize-textarea:focus:not([readonly]) + label {
        color: black !important;
    }
</style>
</head>

<body background="{{ URL::asset('assets/images/login-bg-1.png') }}" class="parallax-container">
  <div id="login-page" class="row">
    <div class="col s12 z-depth-4 card-panel">
      <form method="POST" action="/password/reset" class="login-form">
      {!! csrf_field() !!}
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="row">
          <div class="input-field col s12 center">
          <img src="{{ URL::asset('assets/images/login-door.png') }}" width="80px" alt="">
            <h5>Reset Password</h5>
          </div>
        </div>
        <div class="row">
        @if (count($errors) > 0)
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-communication-email prefix"></i>
            <input id="username" type="email" name="email" value="{{ old('email') }}">
            <label for="username" class="center-align">Email</label>
          </div>
          <div class="input-field col s12">
            <i class="mdi-action-lock-outline prefix"></i>
            <input type="password" name="password" id="password">
            <label for="password" class="center-align">Password</label>
        </div>

        <div class="input-field col s12">
            <i class="mdi-action-lock-outline prefix"></i>
            <input type="password" name="password_confirmation" id="password_confirmation">
            <label for="password_confirmation" class="center-align">Confirm Password</label>
        </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <button class="btn waves-effect waves-light col s12">Reset Password</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- ================================================
    Scripts
    ================================================ -->

    <script src="{{ URL::asset('assets/js/jquery-1.11.2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/materialize.js') }}"></script>
    <script src="{{ URL::asset('assets/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/plugins.js') }}"></script>

</body>
</html>
