<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MENÚ</li>

      @if(auth()->user()->company == 'mbe' || auth()->user()->company == 'owner')
        @each('lte.items', trans('menus/' . $site . '/one'), 'item')
      @else

          @if(auth()->user()->level < 3)
            @each('lte.items', trans('menus/' . $site . '/one'), 'item')
          @else
            @each('lte.items', trans('menus/' . $site . '/two'), 'item')
          @endif

      @endif

    </ul>
    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>
