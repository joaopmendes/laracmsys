<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v2.1.15
* @link https://coreui.io
* Copyright (c) 2018 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->

<html lang="en">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>Backoffice</title>
    <!-- Icons-->
    <link rel="icon" type="image/ico" href="./img/favicon.ico" sizes="any" />
    <link href="{{ asset('vendors/@coreui/icons/css/coreui-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet">
    <!-- Main styles for this application-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/pace-progress/css/pace.min.css') }}" rel="stylesheet">
    <!-- Global site tag (gtag.js) - Google Analytics-->
    @yield('css')

</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    <header class="app-header navbar">
        <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
      </button>
        <a class="navbar-brand" href="#">
            <img class="navbar-brand-full" src="{{asset('img/logo.png')}}" width="75" height="40" alt="CoreUI Logo">
            <img class="navbar-brand-minimized" src="{{asset('img/logo.png')}}" width="74" height="40"  alt="CoreUI Logo">
        </a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
      </button>
        <ul class="nav navbar-nav d-md-down-none">
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Dashboard</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Users</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Settings</a>
            </li>
        </ul>
        <ul class="nav navbar-nav ml-auto">

            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img class="img-avatar" src="{{asset('storage/avatares/' . \Auth::user()->avatar)}}">
                    <span>{{\Auth::user()->name}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">

                    <div class="dropdown-header text-center">
                        <strong>Account</strong>
                    </div>
                    <a class="dropdown-item" href="{{route('user.edit', \Auth::id())}}">
                        <i class="fa fa-user"></i> Edit Profile</a>

                    {!! Form::open(['route' => 'logout', 'method' => 'post']) !!}

                        <button type="submit" class="dropdown-item">
                            <i class="fa fa-lock"></i>Logout
                        </button>
                    {!! Form::close() !!}
                </div>
            </li>
        </ul>

      </button>

      </button>
    </header>
    <div class="app-body">
        <div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">
                            <i class="nav-icon icon-speedometer"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-title">Users & Permissions</li>
                    <li class="nav-item">
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                <i class="nav-icon icon-puzzle"></i> User</a>
                            <ul class="nav-dropdown-items">
                                @can('add user')
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('user.create')}}">
                                            <i class="nav-icon icon-puzzle"></i> Create User</a>
                                    </li>
                                @endcan
                                @can('list user')
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('user.index')}}">
                                            <i class="nav-icon icon-puzzle"></i> List Users</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                <i class="nav-icon icon-puzzle"></i> Permission</a>
                            <ul class="nav-dropdown-items">
                                @can('add permission')
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('permission.create') }}">
                                            <i class="nav-icon icon-puzzle"></i> Create Permission</a>
                                    </li>
                                @endcan
                                @can('list permission')
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('permission.index') }}">
                                            <i class="nav-icon icon-puzzle"></i> List Permissions</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    </li>

                    <li class="nav-title">Content Management</li>
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                <i class="nav-icon icon-puzzle"></i> Base</a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="base/breadcrumb.html">
                                        <i class="nav-icon icon-puzzle"></i> Breadcrumb</a>
                                </li>
                            </ul>
                        </li>
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>
        <main class="main">

            @yield('content')
            <div class="container-fluid">
                <div class="animated fadeIn">

                </div>
            </div>
        </main>

    </div>
    <footer class="app-footer">
        <div>
            <a href="https://github.com/joaopmendes/LaraCmSys">CoreUI</a>
            <span>&copy; 2019 joaopmendes.</span>
        </div>
        <div class="ml-auto">
            <span>Powered by</span>
            <a href="https://coreui.io">CoreUI</a>
        </div>
    </footer>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('vendors/jquery/js/jquery.min.js') }}"></script>
    <script src="{{ asset('vendors/popper.js/js/popper.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/pace-progress/js/pace.min.js') }}"></script>
    <script src="{{ asset('vendors/perfect-scrollbar/js/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('vendors/@coreui/coreui/js/coreui.min.js') }}"></script>
    <!-- Plugins and scripts required by this view-->
    <script src="{{ asset('vendors/chart.js/js/Chart.min.js') }}"></script>
    <script src="{{ asset('vendors/@coreui/coreui-plugin-chartjs-custom-tooltips/js/custom-tooltips.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    @yield('js')

</body>

</html>
