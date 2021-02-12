@extends('coffee.root')

@push('pageTitle', 'Venta | Agregar')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar venta [{{ $last_folio }}]" color="danger">
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
                            <div class="col-md-6 col-md-offset-3">
                                {!! Field::text('client', $retainer->client->name,
                                    ['tpl' => 'withicon', 'disabled' => 'true','required' => 'true'],
                                    ['icon' => 'user'])
                                !!}
                            </div>
                            
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                {!! Field::number('is_retained', $retainer->amount,['tpl' => 'withicon', 'disabled'], ['icon' => 'hand-holding-usd']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                {!! Field::select('invoice', ['no' => 'No require factura', 'G01' => 'G01 Adquisición de mercancías', 'G03' => 'G03 Gastos en general', 'P01' => 'P01 Por definir', 'otro' => 'Otro'], 'no',
                                    ['label' => 'Uso de CFDI', 'tpl' => 'withicon', 'empty' => 'Elegir'],
                                    ['icon' => 'file-invoice'])
                                !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                {!! Field::select('shipping', ['No', 'Sí'], 0,
                                    ['label' => '¿Con envío?', 'tpl' => 'withicon', 'empty' => 'Elegir'],
                                    ['icon' => 'shipping-fast'])
                                !!}
                            </div>
                        </div>
                        <hr>
                      </tab-content>

                      <tab-content title="Productos" icon="fa fa-tag">
                            <shopping-list 
                                color="danger"
                                :retainer="{{ $retainer->amount }}"
                                :exchange="{{ $exchange }}" 
                                :promo="{{ $promo }}">
                            </shopping-list>
                       </tab-content>

                       <tab-content title="Pago" icon="fa fa-dollar">
                            <payment-methods :amount="ingress_total - {{ $retainer->amount }}"></payment-methods>
                       </tab-content>

                    </form-wizard>

                    <input type="hidden" name="method" value="contado">
                    <input type="hidden" name="bought_at" value="{{ date('Y-m-d') }}">
                    <input type="hidden" name="company" value="coffee">
                    <input type="hidden" name="user_id" value="{{ $retainer->user_id }}">
                    <input type="hidden" name="folio" value="{{ $last_folio }}">
                    <input type="hidden" name="retainer_id" value="{{ $retainer->id }}">
                    <input type="hidden" name="client_id" value="{{ $retainer->client_id }}">

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-6">
            <solid-box title="Productos" color="danger">
                <p-table color="danger" :exchange="{{ $exchange }}" type="coffee"></p-table>
            </solid-box>
        </div>
    </div>

@endsection
