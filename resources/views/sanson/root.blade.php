<!DOCTYPE html>
<html>

    @include('lte.htmlhead', ['company' => 'sanson'])

    <body class="hold-transition skin-info sidebar-mini">
        <div id="app">
            <div class="wrapper">
                @include('lte.mainheader', ['logoMini' => "<b>S</b>S", 'logoLg' => "<b>San-</b>Son", 'site' => 'sanson'])
                @include('lte.sidebar', ['site' => 'sanson'])

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
