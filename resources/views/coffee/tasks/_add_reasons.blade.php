<div class="row">
	<div class="col-md-6 col-md-offset-3">
		{!! Form::open(['method' => 'POST', 'route' => ['coffee.task.complete', $task, $date]]) !!}

			{!! Field::textarea('observations', ['tpl' => 'withicon', 'rows' => '2'], ['icon' => 'eye']) !!}

			<br><br>

			{!! Field::select('status', ['aceptada' => 'Aceptada', 'no aceptada' => 'No aceptada'], null, ['tpl' => 'withicon', 'empty' => 'Elija una opción', 'label' => 'Estado'], ['icon' => 'check']) !!}

			<br><br>
			
			{!! Form::submit('GUARDAR', ['class' => 'btn btn-success btn-sm btn-block']) !!}

		{!! Form::close() !!}
	</div>
</div>