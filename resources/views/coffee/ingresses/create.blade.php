@extends('coffee.root')

@push('pageTitle')
    Ingresos | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Crear ingreso" color="danger">
                {!! Form::open(['method' => 'POST', 'route' => 'coffee.ingress.store', 'ref' => 'cform']) !!}

                    <form-wizard
                        title=""
                        subtitle=""
                        color="#dd4b39"
                        @on-complete="submit"
                        back-button-text="Anterior"
                        next-button-text="Siguiente"
                        finish-button-text="Completado">

                      <tab-content title="Cliente" icon="fa fa-user">
                        <div class="row">
                            <div class="col-md-6">
                                <label><b>Cliente</b></label><br>
                                <v-select label="name" :options="{{ $clients }}" v-model="client" placeholder="Seleccione un cliente...">
                                </v-select>
                                <input type="hidden" name="client_id" :value="client.id">
                            </div>
                            <div class="col-md-6">
                                {!! Field::select('is_retained', ['Sí', 'No'], 1,
                                    ['tpl' => 'withicon', 'empty' => '¿Se deja anticipo?', 'v-model.number' => 'is_retained','required' => 'true'],
                                    ['icon' => 'question'])
                                !!}
                            </div>
                        </div>
                        <hr>
                      </tab-content>

                      <tab-content title="Productos" icon="fa fa-tag">
                          <shopping-list color="danger" :exchange="{{ env('EXCHANGE_RATE') }}"></shopping-list>
                       </tab-content>

                       <tab-content title="Pago" icon="fa fa-dollar">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="control-group">
                                        <label>Total a pagar:</label>
                                        <span class="form-control" style="color: green;">
                                            <b>@{{ ingress_total.toFixed(2) }}</b>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    {!! Field::number('cash', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'usd']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    {!! Field::number('debit_card', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'usd']) !!}
                                    {!! Field::number('transfer', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'usd']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Field::number('credit_card', 0, ['tpl' => 'withicon', 'step' => '0.01'], ['icon' => 'usd']) !!}
                                    {!! Field::number('check', 0, ['tpl' => 'withicon', 'step' => '0.01'], ['icon' => 'usd']) !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    {!! Field::text('reference', ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                                </div>
                            </div>

                       </tab-content>

                    </form-wizard>

                    <input type="hidden" name="type" :value="is_retained == 0 ? 'anticipo': 'contado'">
                    <input type="hidden" name="bought_at" value="{{ date('Y-m-d') }}">
                    <input type="hidden" name="company" value="coffee">

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-6">
            <solid-box title="Productos" color="danger">
                <p-table color="danger" :exchange="{{ env('EXCHANGE_RATE') }}"></p-table>
            </solid-box>
        </div>
    </div>

@endsection
