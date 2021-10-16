@extends('sanson.root')

@push('pageTitle', 'Cotización | Agregar')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar cotización" color="{{ $color }}">
                {!! Form::open(['method' => 'POST', 'route' => 'sanson.quotation.store', 'ref' => 'cform']) !!}

                    <form-wizard
                        title=""
                        subtitle=""
                        color="{{ $type == 'equipo' ? '#00c0ef': '#3c8dbc' }}"
                        @on-complete="submit('cotizacion')"
                        back-button-text="Anterior"
                        next-button-text="Siguiente"
                        finish-button-text="Completado">

                      <tab-content title="Cliente" icon="fa fa-user">
                        <div class="row">
                            <div class="col-md-1">
                                <label for="">&nbsp;</label><br>
                                <a class="btn btn-sm btn-{{ $color }}" href="{{ route('sanson.client.create') }}" target="_blank" title="AGREGAR CLIENTE">
                                    <i class="fa fa-user-plus"></i>
                                </a>
                            </div>
                            <div class="col-md-11">
                                <client-select company="sanson" model="quotation"></client-select>
                            </div>
                        </div>
                      </tab-content>

                      <tab-content title="Equipos y refacciones" icon="fa fa-tag">
                          <shopping-cart color="{{ $color }}" :exchange="{{ $exchange }}" :promo="{{ $promo }}"></shopping-cart>
                       </tab-content>

                    </form-wizard>

                    <input type="hidden" name="company" value="sanson">
                    <input type="hidden" name="type" value="{{ $type }}">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-6">
            <solid-box title="Productos" color="{{ $type == 'equipo' ? 'info': 'primary' }}">
                <p-table 
                    color="{{ $type == 'equipo' ? 'info': 'primary'}}" 
                    :exchange="{{ $exchange }}" 
                    :promo="{{ $promo }}" 
                    type="sanson">
                </p-table>
            </solid-box>
        </div>
    </div>

@endsection
