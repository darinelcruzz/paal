@extends('sanson.root')

@push('pageTitle', 'Ventas | Agregar')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar venta [{{ $last_folio }}]" color="{{ $type == 'equipo' ? 'info': 'primary' }}">
                {!! Form::open(['method' => 'POST', 'route' => 'sanson.ingress.store', 'ref' => 'cform']) !!}

                    <form-wizard
                        title=""
                        subtitle=""
                        color="{{ $type == 'equipo' ? '#00c0ef': '#3c8dbc' }}"
                        @on-complete="submit('venta')"
                        back-button-text="Anterior"
                        next-button-text="Siguiente"
                        finish-button-text="Completado">

                      <tab-content title="Cliente" icon="fa fa-user" :before-change="checkIsInvoiced">
                        <div class="row">
                            <div class="col-md-1">
                                <label for="">&nbsp;</label><br>
                                <a class="btn btn-sm btn-info" href="{{ route('sanson.client.create') }}"
                                    target="_blank" title="AGREGAR CLIENTE NUEVO">
                                    <i class="fa fa-user-plus"></i>
                                </a>
                            </div>                            
                            <div class="col-md-11">
                                <client-select company="sanson"></client-select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                {!! Field::select('invoice', ['no' => 'No require factura', 'G01' => 'G01 Adquisición de mercancías', 'G03' => 'G03 Gastos en general', 'P01' => 'P01 Por definir','I08' => 'I08 Otra maquinaria y equipo', 'otro' => 'Otro'], null,
                                    ['label' => 'Uso de CFDI', 'tpl' => 'withicon', 'empty' => 'Elegir', 'v-model' => 'is_invoiced'],
                                    ['icon' => 'file-invoice'])
                                !!}
                            </div>
                            <div class="col-md-6">
                                {!! Field::select('shipping', ['No', 'Sí'], 0,
                                    ['label' => '¿Con envío?', 'tpl' => 'withicon', 'empty' => 'Elegir'],
                                    ['icon' => 'shipping-fast'])
                                !!}
                            </div>
                        </div>
                        <hr>
                      </tab-content>

                      <tab-content title="Productos" icon="fa fa-tag">
                          <shopping-cart 
                            color="{{ $type == 'equipo' ? 'info': 'primary' }}" 
                            :exchange="{{ $exchange }}" 
                            :promo="{{ $promo }}">                              
                          </shopping-cart>
                       </tab-content>

                       <tab-content title="Pago" icon="fa fa-dollar">
                            <payment-methods :amount="ingress_total"></payment-methods>
                       </tab-content>

                       <template slot="footer" slot-scope="props">
                           <div class="wizard-footer-left">
                               <wizard-button v-if="props.activeTabIndex > 0 && !formSubmitted" @click.native="props.prevTab()" :style="props.fillButtonStyle">
                                    <small>ANTERIOR</small>
                                </wizard-button>
                            </div>

                            <div class="wizard-footer-right">
                              <wizard-button v-if="!formSubmitted" @click.native="props.nextTab()" class="wizard-footer-right" :style="props.fillButtonStyle">
                                <small v-text="props.isLastStep ? 'AGREGAR' : 'SIGUIENtE'"></small>
                              </wizard-button>
                            </div>
                        </template>

                    </form-wizard>

                    <input type="hidden" name="company" value="sanson">
                    <input type="hidden" name="type" value="{{ $type }}">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="method" value="contado">
                    <input type="hidden" name="bought_at" value="{{ date('Y-m-d') }}">
                    <input type="hidden" name="folio" value="{{ $last_folio }}">

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-6">
            <solid-box title="Productos" color="{{ $type == 'equipo' ? 'info': 'primary' }}">
                <p-table color="{{ $type == 'equipo' ? 'info': 'primary' }}" :exchange="{{ $exchange }}" :promo="{{ $promo }}" type="sanson"></p-table>
            </solid-box>
        </div>
    </div>

@endsection
