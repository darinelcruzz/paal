@extends('coffee.root')

@push('pageTitle')
    Cotización | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar cotización" color="warning">
                {!! Form::open(['method' => 'POST', 'route' => 'coffee.quotation.store', 'ref' => 'cform']) !!}

                    <form-wizard
                        title=""
                        subtitle=""
                        color="#f39c12"
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
                          <shopping-list color="warning" :exchange="{{ env('EXCHANGE_RATE') }}"></shopping-list>
                       </tab-content>

                    </form-wizard>

                    <input type="hidden" name="company" value="coffee">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-6">
            <solid-box title="Productos" color="warning">
                <p-table color="warning" :exchange="{{ env('EXCHANGE_RATE') }}"></p-table>
            </solid-box>
        </div>
    </div>

@endsection
