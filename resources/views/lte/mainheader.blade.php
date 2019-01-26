<header class="main-header">

  <a href="/{{ $site }}" class="logo">
    <span class="logo-mini">{!! $logoMini !!}</span>
    <span class="logo-lg">{!! $logoLg !!}</span>
  </a>

  <nav class="navbar navbar-static-top" role="navigation">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">

        @if(auth()->user()->company != 'owner')
            <li class="dropdown user user-menu">
              <a href="#">
                <span class="hidden-xs">
                  @auth
                    {{ auth()->user()->name }}
                  @endauth
                </span>
              </a>
            </li>
        @else
            <li class="dropdown user user-menu">
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
