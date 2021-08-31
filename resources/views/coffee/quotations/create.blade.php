@extends('coffee.root')

@push('pageTitle')
    Cotización | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar cotización" color="danger">
                {!! Form::open(['method' => 'POST', 'route' => 'coffee.quotation.store', 'ref' => 'cform']) !!}

                    <form-wizard
                        title=""
                        subtitle=""
                        color="#dd4b39"
                        @on-complete="submit('cotizacion')"
                        back-button-text="Anterior"
                        next-button-text="Siguiente"
                        finish-button-text="Completado">

                      <tab-content title="Cliente" icon="fa fa-user">
                        <div class="row">
                            <div class="col-md-1">
                                <label for="">&nbsp;</label><br>
                                <a class="btn btn-sm btn-danger" href="{{ route('coffee.client.create') }}"
                                    target="_blank" title="AGREGAR CLIENTE NUEVO">
                                    <i class="fa fa-user-plus"></i>
                                </a>
                            </div>                            
                            <div class="col-md-11">
                                <client-select model="quotation"></client-select>
                            </div>
                        </div>
                      </tab-content>

                      <tab-content title="Productos" icon="fa fa-tag">
                          <shopping-list color="danger" :exchange="{{ $exchange }}" :promo="{{ $promo }}"></shopping-list>
                       </tab-content>

                    </form-wizard>

                    <input type="hidden" name="company" value="coffee">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-6">
            <solid-box title="Productos" color="danger">
                <p-table color="danger" :exchange="{{ $exchange }}" :promo="{{ $promo }}" type="coffee"></p-table>
            </solid-box>
        </div>
    </div>

@endsection
