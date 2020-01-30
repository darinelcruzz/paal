@extends('coffee.root')

@push('pageTitle')
    Cotización | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar cotización" color="{{ $type == 'insumos' ? 'danger': 'warning'}}">
                {!! Form::open(['method' => 'POST', 'route' => 'coffee.quotation.store', 'ref' => 'cform']) !!}

                    <form-wizard
                        title=""
                        subtitle=""
                        color="{{ $type == 'insumos' ? '#dd4b39': '#f39c12' }}"
                        @on-complete="submit"
                        back-button-text="Anterior"
                        next-button-text="Siguiente"
                        finish-button-text="Completado">

                      <tab-content title="Cliente" icon="fa fa-user">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <client-select></client-select>
                            </div>
                            
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <a class="btn btn-app" href="{{ route('coffee.client.create') }}" target="_blank">
                                    <i class="fa fa-user-plus"></i> CLIENTE
                                </a>
                            </div>
                        </div>
                        <hr>
                      </tab-content>

                      <tab-content title="Productos" icon="fa fa-tag">
                          <shopping-list color="{{ $type == 'insumos' ? 'danger': 'warning'}}" :exchange="{{ $exchange }}" :promo="{{ $promo }}"></shopping-list>
                       </tab-content>

                    </form-wizard>

                    <input type="hidden" name="company" value="coffee">
                    <input type="hidden" name="type" value="{{ $type }}">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-6">
            <solid-box title="{{ strtoupper($type == 'insumos' ? 'insumos': 'equipos') }}" color="{{ $type == 'insumos' ? 'danger': 'warning' }}">
                <p-table color="{{ $type == 'insumos' ? 'danger': 'warning'}}" :exchange="{{ $exchange }}" :promo="{{ $promo }}" type="coffee/{{ $type }}{{ $type == 'equipo' ? 's': ''}}"></p-table>
            </solid-box>
        </div>
    </div>

@endsection
