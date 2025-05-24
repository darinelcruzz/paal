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
                            <div class="col-md-12">
                                {!! Field::text('client', $quotation->client->name,
                                    ['tpl' => 'withicon', 'disabled' => 'true','required' => 'true'],
                                    ['icon' => 'user'])
                                !!}
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                {!! Field::select('invoice', ['no' => 'No require factura', 'G01' => 'G01 Adquisición de mercancías', 'G03' => 'G03 Gastos en general', 'P01' => 'P01 Por definir', 'otro' => 'Otro'], 'no',
                                    ['label' => 'Uso de CFDI', 'tpl' => 'withicon', 'empty' => 'Elegir'],
                                    ['icon' => 'file-invoice'])
                                !!}
                            </div>
                            <div class="col-md-6">
                                {!! Field::select('shipping', ['No', 'Sí'], 0,
                                    ['label' => '¿Enviar por paquetería?', 'tpl' => 'withicon', 'empty' => 'Elegir'],
                                    ['icon' => 'shipping-fast'])
                                !!}
                            </div>
                        </div>
                        <hr>
                      </tab-content>

                      <tab-content title="Productos" icon="fa fa-tag">
                            <shopping-list 
                                color="danger" 
                                :qproducts="{{ $quotation->products_list }}"
                                :exchange="{{ $exchange }}" 
                                :promo="{{ $promo }}">
                            </shopping-list>
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

                    <input type="hidden" name="method" value="contado">
                    <input type="hidden" name="bought_at" value="{{ date('Y-m-d') }}">
                    <input type="hidden" name="paid_at" value="{{ date('Y-m-d') }}">
                    <input type="hidden" name="company" value="cocinaspaal">
                    <input type="hidden" name="company_id" value="2">
                    <input type="hidden" name="store_id" value="{{ $user->store_id }}">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <input type="hidden" name="folio" value="{{ $last_folio }}">
                    <input type="hidden" name="quotation_id" value="{{ $quotation->id }}">
                    <input type="hidden" name="client_id" value="{{ $quotation->client_id }}">

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
