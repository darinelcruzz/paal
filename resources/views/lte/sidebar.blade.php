<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MENÚ</li>

      {{-- @if(auth()->user()->company == 'mbe')
        @if($isShifted == 1)
          @each('lte.items', trans('menus/' . $site . '/shift'), 'item')
        @else
          @each('lte.items', trans('menus/' . $site . '/one'), 'item')
        @endif
      @else
          @if(auth()->user()->level < 3)
            @each('lte.items', trans('menus/' . $site . '/one'), 'item')
          @else
            @each('lte.items', trans('menus/' . $site . '/two'), 'item')
          @endif
      @endif --}}

      @switch(auth()->user()->company)

        @case('mbe')
          @if($isShifted == 1)
            @each('lte.items', trans('menus/' . $site . '/shift'), 'item')
          @else
            @each('lte.items', trans('menus/' . $site . '/one'), 'item')
          @endif

        @case('coffee')
          @if(auth()->user()->level < 3)
            @each('lte.items', trans('menus/' . $site . '/one'), 'item')
          @else
            @each('lte.items', trans('menus/' . $site . '/two'), 'item')
          @endif

        @case('both')
          @if(auth()->user()->level < 3)
            @each('lte.items', trans('menus/' . $site . '/one'), 'item')
          @else
            @each('lte.items', trans('menus/' . $site . '/two'), 'item')
          @endif

        @default
          @if($isShifted == 1 && $site == 'mbe')
            @each('lte.items', trans('menus/' . $site . '/shift'), 'item')
          @else
            @each('lte.items', trans('menus/' . $site . '/one'), 'item')
          @endif
      @endswitch

    </ul>
    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>
