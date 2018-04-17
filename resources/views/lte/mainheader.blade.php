<header class="main-header">

  <!-- Logo -->
  <a href="intranet/" class="logo">
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
      </ul>
    </div>
  </nav>
</header>
