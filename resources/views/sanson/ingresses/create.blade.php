@extends('sanson.root')

@push('pageTitle')
    Ventas | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar venta [{{ $last_folio }}]" color="{{ $type == 'insumos' ? 'info': 'primary' }}">
                {!! Form::open(['method' => 'POST', 'route' => 'sanson.ingress.store', 'ref' => 'cform']) !!}

                    <form-wizard
                        title=""
                        subtitle=""
                        color="{{ $type == 'insumos' ? '#dd4b39': '#f39c12' }}"
                        @on-complete="submit"
                        back-button-text="Anterior"
                        next-button-text="Siguiente"
                        finish-button-text="Completado">

                      <tab-content title="Cliente" icon="fa fa-user" :before-change="checkIsInvoiced">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <client-select></client-select>
                            </div>
                            
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <a class="btn btn-app" href="{{ route('sanson.client.create') }}" target="_blank">
                                    <i class="fa fa-user-plus"></i> CLIENTE
                                </a>
                            </div>
                            <div class="col-md-6">
                                {!! Field::select('is_retained', ['Sí', 'No'], 1,
                                    ['tpl' => 'withicon', 'empty' => '¿Se deja anticipo?', 'v-model.number' => 'is_retained','required' => 'true'],
                                    ['icon' => 'question'])
                                !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                {!! Field::select('invoice', ['no' => 'No require factura', 'G01' => 'G01 Adquisición de mercancías', 'G03' => 'G03 Gastos en general', 'P01' => 'P01 Por definir', 'otro' => 'Otro'], null,
                                    ['label' => 'Uso de CFDI', 'tpl' => 'withicon', 'empty' => 'Elegir', 'v-model' => 'is_invoiced'],
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
                          <shopping-list color="{{ $type == 'insumos' ? 'info': 'primary' }}" :exchange="{{ $exchange }}" :promo="{{ $promo }}"></shopping-list>
                       </tab-content>

                       <tab-content title="Pago" icon="fa fa-dollar">
                            <payment-methods :amount="ingress_total"></payment-methods>
                       </tab-content>

                    </form-wizard>

                    <input type="hidden" name="method" :value="is_retained == 0 ? 'anticipo': 'contado'">
                    <input type="hidden" name="type" value="{{ $type }}">
                    <input type="hidden" name="bought_at" value="{{ date('Y-m-d') }}">
                    <input type="hidden" name="company" value="sanson">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="folio" value="{{ $last_folio }}">

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-6">
            <solid-box title="{{ $type == 'insumos' ? 'Insumos': 'Equipos' }}" color="{{ $type == 'insumos' ? 'info': 'primary' }}">
                <p-table color="{{ $type == 'insumos' ? 'info': 'primary' }}" :exchange="{{ $exchange }}" :promo="{{ $promo }}" type="{{ $type }}"></p-table>
            </solid-box>
        </div>
    </div>

@endsection
