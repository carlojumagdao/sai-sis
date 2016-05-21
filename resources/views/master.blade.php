<?php
// Created at: Sublime Text 3
// Writer: Carlo Jumagdao
// Date: April 03, 2016
// Time: 11:57pm
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
    <title>@yield('title', 'Home Page')</title> 
    @yield('meta')

    @yield('style')
        <!-- CORE CSS -->
        <link rel="stylesheet" href="{{ URL::asset('assets/css/materialize.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/custom-style.css') }}">
        <!-- CORE CSS -->

        <!-- INCLUDED PLUGIN CSS -->
        <link rel="stylesheet" href="{{ URL::asset('assets/js/plugins/jvectormap/jquery-jvectormap.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/js/plugins/perfect-scrollbar/perfect-scrollbar.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/js/plugins/chartist-js/chartist.min.css') }}">
        <!-- INCLUDED PLUGIN CSS -->
    @show


@yield('charts')
</head>
<body id="content">
    <!-- START HEADER -->
    <header id="header" class="page-topbar">
        <!-- start header nav-->
        <div class="navbar-fixed">
            <nav class="yellow darken-2">
                <div class="nav-wrapper">                    
                    <ul class="left">                      
                      <li><h1 class="logo-wrapper"><a href="{{ URL::to('/') }}" class="brand-logo darken-1"><img src="{{ URL::asset('assets/images/sailogo-black.png') }}" alt="SAI Logo"></a> <span class="logo-text">Silid Aralan</span></h1></li>
                    </ul>
                    <ul class="right hide-on-med-and-down">   
                        <li><a href="javascript:void(0);" class="waves-effect waves-block waves-light toggle-fullscreen black-text"><i class="mdi-action-settings-overscan"></i></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- end header nav-->
    </header>
     <!-- End HEADER -->

    <!-- START LEFT SIDEBAR NAV-->
    <div id="main">
        <!-- START LEFT SIDEBAR NAV-->
        <div id="wrapper">
            <!-- START LEFT SIDEBAR NAV-->
            <aside id="left-sidebar-nav">
                <ul id="slide-out" class="side-nav fixed leftside-navigation">
                    <li class="user-details blue-grey darken-4">
                        <div class="row">
                            <div class="col col s4 m4 l4">
                            <?php $pathname = session('picname'); ?>
                                <img src="{{ URL::asset('assets/images/user-uploads/'.$pathname.'') }}" alt="" class="circle responsive-img valign profile-image">
                                
                            </div>
                            <div class="col col s8 m8 l8">
                                <ul id="profile-dropdown" class="dropdown-content">
                                    <li><a href="{{ URL::to('user/profile') }}"><i class="mdi-action-face-unlock"></i> Profile</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li><a href="{{ URL::to('auth/logout') }}"><i class="mdi-hardware-keyboard-tab"></i> Logout</a>
                                    </li>
                                </ul>
                                <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown">{{session('name')}}<i class="mdi-navigation-arrow-drop-down right"></i></a>
                                <p class="user-roal">
                                    @if(session('admin'))
                                        {{"Administrator"}}
                                    @else
                                        {{"Coordinator"}}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="bold"><a href="{{ URL::to('/') }}" class="waves-effect waves-cyan"><i class="mdi-action-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="bold"><a href="{{ URL::to('learner') }}" class="waves-effect waves-cyan"><i class="mdi-social-school"></i> Learners </a>
                    </li>
                    <li class="bold"><a href="{{ URL::to('donor') }}" class="waves-effect waves-cyan"><i class="mdi-maps-location-history"></i> Donors </a>
                    </li>
                    <li class="bold"><a href="{{ URL::to('session') }}" class="waves-effect waves-cyan"><i class="mdi-editor-insert-invitation"></i> Session </a>
                    </li>
                    <li class="bold"><a href="{{ URL::to('colearner') }}" class="waves-effect waves-cyan"><i class="mdi-social-people-outline"></i> Co-learners </a>
                    </li>
                    <li class="bold"><a href="{{ URL::to('program') }}" class="waves-effect waves-cyan"><i class="mdi-action-redeem"></i> Programs </a>
                    </li>
                    <li class="bold"><a href="{{ URL::to('school') }}" class="waves-effect waves-cyan"><i class="mdi-action-account-balance-wallet"></i> School </a>
                    </li>
                    <li class="bold"><a href="{{ URL::to('user') }}" class="waves-effect waves-cyan"><i class="mdi-social-person"></i> Users </a>
                    </li>
                    <li class="bold"><a href="{{ URL::to('learningcenter') }}" class="waves-effect waves-cyan"><i class="mdi-maps-store-mall-directory"></i> Learning Center </a>
                    </li>
                    <li class="li-hover"><div class="divider"></div></li>
                    <li class="no-padding">
                    <span class="new badge">{{session('bdays')}}</span>
                    <li class="bold"><a href="{{ URL::to('birthday') }}" class="waves-effect waves-cyan"><i class="mdi-social-cake"></i></i> Birthdays </a>
                    </li>
                        <ul class="collapsible collapsible-accordion">
                            <li class="bold"><a class="collapsible-header waves-effect waves-cyan"><i class="mdi-editor-insert-chart"></i> Reports</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="{{ URL::to('report/grades') }}">Grades</a>
                                        </li>                                        
                                        <li><a href="{{ URL::to('report/attendance') }}">Attendance</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
            </aside>
            <!-- END LEFT SIDEBAR NAV-->

            <!-- Content Area -->
            <div>
                <section id="content">
                    <div class="col s12 m12 s12">
                        <div class="custom-card white">
                            <div class="card-content black-text">
                                <h5>@yield('title-page', 'Home Page')</h5>
                            </div>
                        </div>
                    </div>
                    <!--breadcrumbs end-->
                @yield('content')
            </div>
            <!-- End Content Area -->
        </div>
        <!-- END WRAPPER-->
    </div>
    <!-- END MAIN-->

    <!-- START FOOTER -->
    <footer class="page-footer">
        <div class="footer-copyright yellow darken-2">
            <div class="container yellow darken-2">
                <span class="black-text">Copyright © 2016 <b><a class="black-text text-lighten-4" href="#!" target="_blank">Silid Aralan, Inc.</a></b> All rights reserved.</span>
            </div>
        </div>
    </footer>
    <!-- END FOOTER -->

    <!-- Script Footer -->
    <script src="{{ URL::asset('assets/js/jquery-1.11.2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/materialize.js') }}"></script>
    <script src="{{ URL::asset('assets/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
     @yield('javascript')
    <script src="{{ URL::asset('assets/js/plugins/chartist-js/chartist.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/plugins/sparkline/sparkline-script.js') }}"></script>
    <script src="{{ URL::asset('assets/js/plugins.js') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });
    </script>
    <script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    @yield('script')
    </script>

</body>
</html>
