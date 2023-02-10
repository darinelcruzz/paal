@extends('coffee.root')

@push('pageTitle', 'Cotización | Agregar')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar cotización" color="warning">
                {!! Form::open(['method' => 'POST', 'route' => 'coffee.quotation.store', 'ref' => 'cform']) !!}

                    <form-wizard
                        title=""
                        subtitle=""
                        color="#f39c12"
                        @on-complete="submit('cotizacion')"
                        back-button-text="Anterior"
                        next-button-text="Siguiente"
                        finish-button-text="Completado">

                      <tab-content title="Cliente" icon="fa fa-user">
                        <div class="row">
                            <div class="col-md-1">
                                <label for="">&nbsp;</label><br>
                                <a class="btn btn-sm btn-warning" href="{{ route('coffee.client.create') }}"
                                    target="_blank" title="AGREGAR CLIENTE NUEVO">
                                    <i class="fa fa-user-plus"></i>
                                </a>
                            </div>                            
                            <div class="col-md-11">
                                <client-select model="quotation"></client-select>
                            </div>
                        </div>
                        <hr>
                      </tab-content>

                      <tab-content title="Productos" icon="fa fa-tag">
                          <shopping-list color="danger" :exchange="{{ $exchange }}" :promo="{{ $promo }}"></shopping-list>
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

                    <input type="hidden" name="company" value="cocinaspaal">
                    <input type="hidden" name="company_id" value="2">
                    <input type="hidden" name="store_id" value="{{ $user->store_id }}">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-6">
            <solid-box title="Productos" color="warning">
                <p-table color="warning" :exchange="{{ $exchange }}" :promo="{{ $promo }}" type="coffee"></p-table>
            </solid-box>
        </div>
    </div>

@endsection
