<header class="main-header">

  <a href="/{{ $site == 'coffee' ? 'cocinaspaal': $site }}" class="logo">
    <span class="logo-mini">{!! $logoMini !!}</span>
    <span class="logo-lg">{!! $logoLg !!}</span>
  </a>

  <nav class="navbar navbar-static-top" role="navigation">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        
        <notifications icon="bell" color="primary" company="{{ $site }}"></notifications>
              
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
                @if(auth()->user()->level <= 1)
                  <a href="/cocinaspaal" class="btn btn-default" style="color: #f39c12;">COCINAS<b>PAAL</b></a>
                  <a href="/mbe" class="btn btn-default" style="color: #00a65a;">LOGÍSTICA<b>PAAL</b></a>
                  <a href="/paal" class="btn btn-default" style="color: #3c8dbc;">PAAL</a>
                @elseif(auth()->user()->store_id == 3)
                  <a href="/mbe" class="btn btn-default" style="color: #00a65a;">LOGÍSTICA<b>PAAL</b></a>
                  <a href="/cambiar-tienda/5" class="btn btn-default" style="color: #f39c20;">COCINAS<b>PAAL</b> | DIGITAL</a>
                @elseif(auth()->user()->store_id == 2)
                  <a href="/cocinaspaal" class="btn btn-default" style="color: #f39c12;">COCINAS<b>PAAL</b></a>
                @endif
              </li>
          </ul>
        </li>

      </ul>
    </div>
  </nav>
</header>
