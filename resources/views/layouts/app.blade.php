<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('storage/img/favicon.png') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">

        <div class="wrapper">
            <div class="sidebar" data-image="{{ asset('/img/sidebar-5.jpg') }}" data-color="blue">
                <!--
                    Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

                    Tip 2: you can also add an image using data-image tag
                -->
                <div class="sidebar-wrapper">
                    <div class="logo">
                        <a href="#" class="simple-text">
                            ASSIGNMENT PORTAL
                        </a>
                    </div>
                    <ul class="nav">

                        @role('admin')
                        <li class="nav-item {{ Request::is('home') || Request::is('/') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/home') }}">
                                <i class="nc-icon nc-chart-pie-35"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="{{ Request::is('companies*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/companies') }}">
                                <i class="nc-icon nc-bag"></i>
                                <p>Providers</p>
                            </a>
                        </li>
                        @endrole

                        @if(Auth::user()->hasRole('representative'))
                        <li class="{{ Request::is('companies*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('companies/'.Auth::user()->company_id) }}">
                                <i class="nc-icon nc-bag"></i>
                                <p>Members</p>
                            </a>
                        </li>
                        @endif

                        <li class="{{ Request::is('relievers*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/relievers') }}">
                                <i class="nc-icon nc-paper-2"></i>
                                <p>Assigned</p>
                            </a>
                        </li>

                        @if(Auth::user()->hasRole('representative'))
                        <li class="{{ Request::is('profile/edit*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('profile/edit/'.Auth::user()->id) }}">
                                <i class="nc-icon nc-circle-09"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                        @endif

                        @role('admin')
                        {{-- <li class="{{ Request::is('approvals*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/approvals') }}">
                                <i class="nc-icon nc-bell-55"></i>
                                <p>Approvals</p>
                            </a>
                        </li> --}}
                        <li class="{{ Request::is('users*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/users') }}">
                                <i class="nc-icon nc-circle-09"></i>
                                <p>User Profile</p>
                            </a>
                        </li>
                        <li class="{{ Request::is('rolePerms*') ? 'active' : '' }}">
                            <a class="nav-link disabled" href="{{ url('/rolePerms') }}">
                                <i class="nc-icon nc-lock-circle-open"></i>
                                <p>Roles & Permission</p>
                            </a>
                        </li>

                        @endrole

                        <li class="nav-item active active-pro">
                            <a class="nav-link active" data-toggle="modal" data-target="#logoutModal" href="javascript:void(0);">
                                <i class="nc-icon nc-button-power"></i>
                                <p>Sign Out</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-panel">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                    <div class=" container-fluid  ">
                        <a class="navbar-brand" href="#pablo">

                            @if(Request::is('home') || Request::is('/'))
                            Dashboard
                            @elseif(Request::is('companies*'))
                            Companies
                            @elseif(Request::is('relievers*'))
                            Relievers
                            @elseif(Request::is('approvals*'))
                            Approvals
                            @elseif(Request::is('users*'))
                            Users
                            @elseif(Request::is('rolePerms*'))
                            Roles & Permission
                            @else
                            Independent Contractual
                            @endif

                        </a>
                        <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-bar burger-lines"></span>
                            <span class="navbar-toggler-bar burger-lines"></span>
                            <span class="navbar-toggler-bar burger-lines"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navigation">
                            <ul class="nav navbar-nav mr-auto">
                                <li class="nav-item">
                                    <a href="#" class="nav-link" data-toggle="dropdown">
                                        <span class="d-lg-none">Dashboard</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link"  href="javascript:void(0);">
                                        <span class="no-icon">Hello, {{ Auth::user()->name }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- End Navbar -->
                <div class="content">
                    <div class="container-fluid">

                        @yield('content')

                    </div>
                    <!-- end container-fluid -->
                </div>
                <!-- end content -->

                <footer class="footer">
                    <div class="container">
                        <nav>
                            <ul class="footer-menu">
                                <li>
                                    <a href="#">
                                        La Filipina Uy Gongco Group of Companies
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </footer>
            </div>
        </div>

        <!-- Logout Modal -->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutModalLabel">Ready to Leave?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Select "Logout" below if you are ready to end your current session.
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary btn-fill" data-dismiss="modal">Cancel</button>

                        <a class="btn btn-primary btn-fill" href="javascript::void(0);" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Confirm</a>

                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <!-- disclaimer modal -->
        @if(Auth::user()->disclaimer == 0)
            <disclaimer :user="{{ Auth::user()->id }}"></disclaimer>
        @endif

    </div><!-- end app -->

    <!-- Scripts -->
    <script src="{{ asset('js/all.js') }}"></script>

    @include('flashy::message')

    @yield('script')

</body>
</html>
