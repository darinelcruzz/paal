<!DOCTYPE html>
<html>

    @include('lte.htmlhead', ['company' => 'cocinaspaal'])

    <body class="hold-transition skin-yellow sidebar-mini">
        <div id="app">
            <div class="wrapper">
                @include('lte.mainheader', ['logoMini' => "<b>C</b>P", 'logoLg' => "<b>Cocinas</b>PAAL", 'site' => 'coffee'])
                @include('lte.sidebar', ['site' => 'coffee'])

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
