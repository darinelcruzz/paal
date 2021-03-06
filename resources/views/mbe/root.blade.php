<!DOCTYPE html>
<html>

    @include('lte.htmlhead', ['company' => 'mbe'])

    <body class="hold-transition skin-green sidebar-mini">
        <div id="app">
            <div class="wrapper">
                @include('lte.mainheader', ['logoMini' => "<b>M</b>BE", 'logoLg' => "<b>Mail</b>boxes", 'site' => 'mbe'])
                @include('lte.sidebar', ['site' => 'mbe'])

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
