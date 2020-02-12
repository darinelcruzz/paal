@extends('sanson.root')

@push('pageTitle')
    Cotización | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-7">
            <solid-box title="Agregar cotización" color="{{ $type == 'equipo' ? 'info': 'primary'}}">
                {!! Form::open(['method' => 'POST', 'route' => 'sanson.quotation.store', 'ref' => 'cform']) !!}

                    <form-wizard
                        title=""
                        subtitle=""
                        color="{{ $type == 'equipo' ? '#00c0ef': '#3c8dbc' }}"
                        @on-complete="submit"
                        back-button-text="Anterior"
                        next-button-text="Siguiente"
                        finish-button-text="Completado">

                      <tab-content title="Cliente" icon="fa fa-user">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <client-select company="sanson"></client-select>
                            </div>
                            
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <a class="btn btn-app" href="{{ route('sanson.client.create') }}" target="_blank">
                                    <i class="fa fa-user-plus"></i> CLIENTE
                                </a>
                            </div>
                        </div>
                        <hr>
                      </tab-content>

                      <tab-content title="Equipos y refacciones" icon="fa fa-tag">
                          <shopping-cart color="{{ $type == 'equipo' ? 'info': 'primary'}}" :exchange="{{ $exchange }}" :promo="{{ $promo }}"></shopping-cart>
                       </tab-content>

                    </form-wizard>

                    <input type="hidden" name="company" value="sanson">
                    <input type="hidden" name="type" value="{{ $type }}">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-5">
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
