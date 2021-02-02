<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MENÚ</li>

      @switch(auth()->user()->company)

        @case('mbe')
          @if($isShifted == 1)
            @each('lte.items', trans('menus/' . $site . '/shift'), 'item')
          @else
            @each('lte.items', trans('menus/' . $site . '/one'), 'item')
          @endif

          @break

        @case('coffee')
          @if(auth()->user()->level < 3)
            @each('lte.items', trans('menus/' . $site . '/one'), 'item')
          @else
            @each('lte.items', trans('menus/' . $site . '/two'), 'item')
          @endif

          @break

        @case('both')
          @if(auth()->user()->level < 3)
            @each('lte.items', trans('menus/' . $site . '/one'), 'item')
          @else
            @each('lte.items', trans('menus/' . $site . '/two'), 'item')
          @endif

          @break

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
