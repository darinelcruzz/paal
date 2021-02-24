@extends('coffee.root')

@push('pageTitle')
    Número de guía y +
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <solid-box title="Agregar información de envío" color="danger" button>

                {!! Form::open(['method' => 'POST', 'route' => ['coffee.shipping.update', $shipping]]) !!}

                	<div class="row">
                		<div class="col-md-6">
                			{!! Field::select('company', 
								[
									'estafeta' => 'Estafeta', 
									'paquete express' => 'Paquete Express', 
									'dypaq' => 'DYPAQ', 
									'business express' => 'Business Express', 
									'motor pack' => 'Motor Pack', 
									'pack service' => 'Pack Service (AEXA)', 
									'mbe etc' => 'MBE ETC', 
									'otro' => 'Otro'
								],
								null,
								['tpl' => 'withicon', 'empty' => 'Seleccione una paquetería', 'v-model' => 'provider'], ['icon' => 'shipping-fast']) 
							!!}
                		</div>
                		<div v-if="provider != 'mbe etc'" class="col-md-6">
                			{!! Field::text('guide_number', ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                		</div>
                		<div v-else class="col-md-6">
                			{!! Field::text('guide_number', $shipping->ingress->folio, ['tpl' => 'withicon', 'disabled'], ['icon' => 'barcode']) !!}
                			<input type="hidden" name="guide_number" value="{{ $shipping->ingress->folio }}">
                		</div>
                	</div>

					@if ($addresses)
						{!! Field::select('address_id', $addresses, null,
							['label' => 'Dirección', 'tpl' => 'withicon', 'empty' => 'Seleccione una dirección'], ['icon' => 'map-marked-alt']) 
						!!}
					@else
						<code>No hay direcciones de envío (en el rótulo se pondrá la dirección principal)</code>
					@endif

					<hr>

					<input type="hidden" name="shipped_at" value="{{ date('Y-m-d') }}">
					<input type="hidden" name="status" value="en tránsito">
					
					{!! Form::submit('GUARDAR', ['class' => 'btn btn-danger	 btn-sm btn-block']) !!}

				{!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection
