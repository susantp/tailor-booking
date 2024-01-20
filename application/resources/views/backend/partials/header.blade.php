<header class="main-header">
    <!-- Logo -->
    <a href="{{config('site.admin')}}dashboard" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>S</b>hell</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Sept</b>Shell</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="{{url('/')}}" target="_blank" class="dropdown-toggle">
                        <span class="hidden-xs">Visit Site</span>
                    </a>

                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{asset('assets/backend/img/fly.png')}}" class="user-image" alt="Backend User">
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{asset('assets/backend/img/fly.png')}}" class="img-circle" alt="Backend User">
                            <p>
                                Logged in as: 
                                {{ Auth::user()->name }}
                                <small>{{ Auth::user()->email }}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body hidden">
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <a href="#">Login Time: 7AM</a>
                                </div>

                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{route('reset.password') }}" class="btn btn-default btn-flat">Change password</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('BACKEND-LOGOUT') }}" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>