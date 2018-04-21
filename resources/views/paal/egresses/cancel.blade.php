
{!! Form::open(['method' => 'POST', 'route' => 'paal.egress.destroy']) !!}

    <div class="row">
        <div class="col-md-12">
            {!! Field::textarea('observations', 
                ['label' => 'Escriba los motivos de la cancelación',
                'rows' => "4"]) 
            !!}
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <input type="hidden" name="id" value="{{ $egress->id }}">
            <input type="hidden" name="user" value="{{ auth()->user()->name }}">
            {!! Form::submit('Cancelar', ['class' => 'btn btn-danger pull-right']) !!}
        </div>
    </div>
    
{!! Form::close() !!}