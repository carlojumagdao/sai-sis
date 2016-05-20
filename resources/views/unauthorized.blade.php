<?php
// Created at: Sublime Text 3
// Writer: Carlo Jumagdao
// Date: April 15, 2016
// Time: 10:17am
?>

<!DOCTYPE>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="Silid Aralan, Inc. is a non-profit organization that supports low performing students.">
    <meta name="keywords" content="Silid Aralan, NGO, Education, Silid, Non-profit Organization,">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>Unauthorized</title> 

        <!-- CORE CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/materialize.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">
    <!-- <link rel="stylesheet" href="{{ URL::asset('assets/css/custom-style.css') }}"> -->
    <!-- CORE CSS -->

    <!-- INCLUDED PLUGIN CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/js/plugins/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/js/plugins/chartist-js/chartist.min.css') }}">
</head>

<body class="cyan">
<div>&nbsp;</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
  <div id="error-page">
    <div class="row">
      <div class="col s12 m12 l6 offset-l3">
        <div class="browser-window">
          <div class="top-bar">
            <div class="circles">
              <div id="close-circle" class="circle"></div>
              <div id="minimize-circle" class="circle"></div>
              <div id="maximize-circle" class="circle"></div>
            </div>
          </div>
          <div class="content">
            <div class="row">
              <div id="site-layout-example-top" class="col s12">
                <p class="flat-text-logo center white-text caption-uppercase">UNAUTHORIZED</p>
              </div>
              <div id="site-layout-example-right" class="col s12 m12 l12">
                <div class="row center">
                  <h1 class="text-long-shadow col s12">401</h1>
                </div>
                <div class="row center">
                  <p class="center white-text col s12">This is a restricted web page.</p>
                  <p class="center s12"><button onclick="goBack()" class="btn waves-effect waves-light">Back</button> <a href="/" class="btn waves-effect waves-light">Homepage</a>
                    <p>
                    </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    <!-- Script Footer -->
    <script src="{{ URL::asset('assets/js/jquery-1.11.2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/materialize.js') }}"></script>
    <script src="{{ URL::asset('assets/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/plugins/chartist-js/chartist.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/plugins.js') }}"></script>
    <script type="text/javascript">
    function goBack() {
      window.history.back();
    }
  </script>

</body>
</html>