@extends('paal.root')

@push('pageTitle')
    PAAL | Reportes
@endpush

@section('content')

	<div class="row">
		<div class="col-md-6">
			<solid-box title="Descargar reporte" color="primary" solid>
				{!! Form::open(['method' => 'POST', 'route' => 'paal.report.pending']) !!}
				EGRESOS TOTALES:
				<div class="row">
					<div class="col-md-5">
						{!! Field::date('from', date('Y-m-d'), ['tpl' => 'nolabel'], ['icon' => 'calendar']) !!}
					</div>
					<div class="col-md-5">
						{!! Field::date('to', date('Y-m-d'), ['tpl' => 'nolabel'], ['icon' => 'calendar']) !!}
					</div>
					<div class="col-md-2">
						<button type="submit" class="btn btn-primary btn-block btn-sm"><big><i class="fa fa-download"></i></big></button>
					</div>
				</div>
				{!! Form::close() !!}

				<hr>
				{!! Form::open(['method' => 'POST', 'route' => 'paal.report.paid']) !!}
				PAGADOS:
				<div class="row">
					<div class="col-md-5">
						{!! Field::date('from', date('Y-m-d'), ['tpl' => 'nolabel'], ['icon' => 'calendar']) !!}
					</div>
					<div class="col-md-5">
						{!! Field::date('to', date('Y-m-d'), ['tpl' => 'nolabel'], ['icon' => 'calendar']) !!}
					</div>
					<div class="col-md-2">
						<button type="submit" class="btn btn-primary btn-block btn-sm"><big><i class="fa fa-download"></i></big></button>
					</div>
				</div>
				{!! Form::close() !!}
			</solid-box>
		</div>
	</div>

@endsection