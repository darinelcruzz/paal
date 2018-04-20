<!DOCTYPE html>
<html>

    @include('lte.htmlhead')

    <body class="hold-transition skin-blue sidebar-mini">
        <div id="app">
            <div class="wrapper">
                @include('lte.mainheader', ['logoMini' => "<b>A</b>P", 'logoLg' => "<b>Admin</b>Paal", 'site' => 'paal'])
                @include('lte.sidebar', ['site' => 'paal'])

                <div class="content-wrapper">
                    <section class="content-header">
                        <h1>@stack('headerTitle')</h1>
                    </section>

                    <section class="content container-fluid">
                        @yield('content')
                    </section>
                </div>

                @include('lte.footer')
            </div>
        </div>

        @include('lte.scripts')

    </body>
</html>