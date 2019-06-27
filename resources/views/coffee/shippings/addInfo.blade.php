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
                			{!! Field::text('guide_number', ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                		</div>
                		<div class="col-md-6">
                			{!! Field::select('company', 
								[
									'estafeta' => 'Estafeta', 
									'paquete express' => 'Paquete Express', 
									'dypaq' => 'DYPAQ', 
									'business express' => 'Business Express', 
									'moto pack' => 'Moto Pack', 
									'pack service' => 'Pack Service (AEXA)', 
									'otro' => 'Otro'
								],
								null,
								['tpl' => 'withicon', 'empty' => 'Seleccione una paquetería'], ['icon' => 'shipping-fast']) 
							!!}
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