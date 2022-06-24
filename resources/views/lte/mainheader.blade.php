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
                @if(auth()->user()->company == 'owner' || (auth()->user()->company == 'paal+'))
                  <a href="/cocinaspaal" class="btn btn-default" style="color: #f39c12;">COCINAS PAAL</a>
                  <a href="/mbe" class="btn btn-default" style="color: #00a65a;">MAILBOXES</a>
                  {{-- <a href="/sanson" class="btn btn-default" style="color: #00c0ef;">SANSON</a> --}}
                  <a href="/paal" class="btn btn-default" style="color: #3c8dbc;">LOGÍSTICA PAAL</a>
                @elseif(auth()->user()->company == 'both')
                  <a href="/cocinaspaal" class="btn btn-default" style="color: #f39c12;">COCINAS PAAL</a>
                  <a href="/mbe" class="btn btn-default" style="color: #00a65a;">MAILBOXES</a>
                  {{-- <a href="/sanson" class="btn btn-default" style="color: #00c0ef;">SANSON</a> --}}
                @elseif(auth()->user()->company == 'coffee')
                  <a href="/cocinaspaal" class="btn btn-default" style="color: #f39c12;">COCINAS PAAL</a>
                  {{-- <a href="/sanson" class="btn btn-default" style="color: #00c0ef;">SANSON</a> --}}
                @endif
              </li>
          </ul>
        </li>

      </ul>
    </div>
  </nav>
</header>
