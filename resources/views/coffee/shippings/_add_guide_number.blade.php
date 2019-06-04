<div class="row">
	<div class="col-md-4 col-md-offset-4">
		{!! Form::open(['method' => 'POST', 'route' => ['coffee.shipping.update', $shipping]]) !!}

			{!! Field::text('company', ['tpl' => 'withicon'], ['icon' => 'shipping-fast']) !!}
			
			{!! Field::text('guide_number', ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}

			<br><br>
			
			{!! Form::submit('GUARDAR', ['class' => 'btn btn-success btn-sm btn-block']) !!}

		{!! Form::close() !!}
	</div>
</div>