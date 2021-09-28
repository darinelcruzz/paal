<!DOCTYPE html>
<html>

@include('lte.htmlhead')

<body class="hold-transition login-page">
        <div class="login-box">

            <div class="login-box-body">

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8" align="center" valign="middle">
                        {{-- <img width="100%" height="100%" src="{{ asset("/img/logo.png") }}"> --}}
                        <img width="100%" height="100%" src="{{ asset("img/$company.png") }}">
                    </div>
                </div>

                {!! Form::open(['method' => 'POST', 'route' => 'login', 'class' => 'form-horizontal']) !!}

                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        {!! Field::text('username',
                            ['label' => 'Usuario', 'value' => old('user'), 'tpl' => 'withicon'],
                            ['icon' => 'user-circle']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        {!! Field::password('password',
                            ['tpl' => 'withicon'], ['icon' => 'key']) !!}
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <input type="hidden" value="{{ $company }}" name="company">
                        <button type="submit" class="btn btn-default btn-block">
                            <b>E N T R A R &nbsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-forward"></i> </b>
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
</body>

</html>