<header class="main-header">

  <!-- Logo -->
  <a href="/{{ $site }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini">{!! $logoMini !!}</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg">{!! $logoLg !!}</span>
  </a>

  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">

        <!-- User Account Menu -->
        @if(auth()->user()->company != 'owner')
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs">
                  @auth
                    {{ auth()->user()->name }}
                  @endauth
                </span>
              </a>
            </li>
        @else
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset('img/user-admin.png') }}" class="user-image" alt="User Image">
                <span class="hidden-xs">
                  @auth
                    {{ auth()->user()->name }}
                  @endauth
                </span>
              </a>

              <ul class="dropdown-menu">
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="/coffee" class="btn btn-default btn-flat"><span style="color: red;">Coffee</span></a>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <a href="/paal" class="btn btn-default btn-flat"><span style="color: blue;">PAAL</span></a>
                    </div>
                    <div class="pull-right">
                      <a href="/mbe" class="btn btn-default btn-flat" class="pull-right"><span style="color: green;">MBE</span></a>
                    </div>
                  </li>
              </ul>
            </li>
        @endif

      </ul>
    </div>
  </nav>
</header>
