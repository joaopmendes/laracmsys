<!DOCTYPE html>
<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Blog CMS System">
    <meta name="author" content="joaopmendes">
    <meta name="csrf_token" content="{{csrf_token()}}">
    <meta name="APP_URL" content="{{env('APP_URL')}}">
    <meta name="keyword" content="Bootstrap,Admin,CMS,Blog,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />

    @yield('css')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.9/css/mdb.min.css" rel="stylesheet">

    <style>
        #sidebar li .active, #sidebar a:hover {
            background: #247394  !important;
        }
        #sidebar{
            font-size: 13px;
        }
    </style>
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
                <a class="nav-link" href="{{ route('backoffice.index') }}">Dashboard</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="{{ route('user.index') }}">Users</a>
            </li>
        </ul>
        <ul class="nav navbar-nav ml-auto">

            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img class="img-avatar" src="{{asset( \Auth::user()->avatar == "defaultuser.jpg" ? "img/avatars/" . \Auth::user()->avatar : 'storage/avatares/' . \Auth::user()->avatar)}}">
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
        <div class="sidebar" id="sidebar">
            <li class="sidebar-nav">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">
                            <i class="nav-icon icon-speedometer"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-title">Users & Permissions</li>
                    @canany(["add user", "list user"])
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
                        @endcanany
                        @canany(["add permission", "list permission"])
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
                        @endcanany

                        </li>

                    <li class="nav-title">Blog Management</li>
                        @canany(['add tag', 'edit tag'])
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                <i class="nav-icon icon-puzzle"></i> Tags</a>
                            <ul class="nav-dropdown-items">
                                @can('add tag')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('tag.create')}}">
                                        <i class="nav-icon icon-puzzle"></i> Create Tag</a>
                                </li>
                                @endcan
                                @can("list tag")
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('tag.index')}}">
                                        <i class="nav-icon icon-puzzle"></i> List Tags</a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcanany

                        @canany(['add post', 'edit post'])
                            <li class="nav-item nav-dropdown">
                                <a class="nav-link nav-dropdown-toggle" href="#">
                                    <i class="nav-icon icon-puzzle"></i> Posts</a>
                                <ul class="nav-dropdown-items">
                                    @can('add post')
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{route('post.create')}}">
                                                <i class="nav-icon icon-puzzle"></i> Create Post</a>
                                        </li>
                                    @endcan
                                    @can("list post")
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{route('post.index')}}">
                                                <i class="nav-icon icon-puzzle"></i> List Post</a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany
                        <li class="nav-title">Content Management</li>
                        @canany(['add article', 'edit article'])
                            <li class="nav-item nav-dropdown">
                                <a class="nav-link nav-dropdown-toggle" href="#">
                                    <i class="nav-icon icon-puzzle"></i> Article</a>
                                <ul class="nav-dropdown-items">
                                    @can('add article')
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{route('article.create')}}">
                                                <i class="nav-icon icon-puzzle"></i> Create Article</a>
                                        </li>
                                    @endcan
                                    @can("list article")
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{route('article.index')}}">
                                                <i class="nav-icon icon-puzzle"></i> List Articles</a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany
                            <li class="nav-title">Others</li>
                            @canany(['add file', 'edit file'])
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('file.index') }}">
                                        <i class="nav-icon icon-puzzle"></i> Multimedia</a>
                                </li>
                            @endcanany


                        @canany(['add language', 'edit language'])
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                <i class="nav-icon icon-puzzle"></i> Languages</a>
                            <ul class="nav-dropdown-items">
                                @can('add language')
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('language.create')}}">
                                            <i class="nav-icon icon-puzzle"></i> Create Language</a>
                                    </li>
                                @endcan
                                @can("list post")
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('language.index')}}">
                                            <i class="nav-icon icon-puzzle"></i> List Languages</a>
                                    </li>
                                @endcan
                            </ul>

                        @endcanany

                            </ul>
                        </li>
                    </ul>

            </nav>
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
        <div class="w-100">
            <span class="text-center w-100 d-block">&copy; 2019 joaopmendes.</span>
        </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script></script>
    <script src="{{ asset('vendors/popper.js/js/popper.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/pace-progress/js/pace.min.js') }}"></script>
    <script src="{{ asset('vendors/perfect-scrollbar/js/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('vendors/@coreui/coreui/js/coreui.min.js') }}"></script>
    <!-- Plugins and scripts required by this view-->
    <script src="{{ asset('vendors/@coreui/coreui-plugin-chartjs-custom-tooltips/js/custom-tooltips.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script src="//cdn.ckeditor.com/4.12.1/full/ckeditor.js"></script>

    @yield('js')
    <!-- Bootstrap tooltips -->

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.9/js/mdb.min.js"></script>


</body>

</html>
