@extends('paal.root')

@push('pageTitle')
    PAAL | Reportes
@endpush

@section('content')

	<div class="row">
		<div class="col-md-6">
			<solid-box title="EGRESOS TOTALES" color="primary" solid>
				{!! Form::open(['method' => 'POST', 'route' => 'paal.report.pending']) !!}
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

		<div class="col-md-6">
			<solid-box title="PAGADOS" color="success" solid>
				{!! Form::open(['method' => 'POST', 'route' => 'paal.report.paid']) !!}
				<div class="row">
					<div class="col-md-5">
						{!! Field::date('from', date('Y-m-d'), ['tpl' => 'nolabel'], ['icon' => 'calendar']) !!}
					</div>
					<div class="col-md-5">
						{!! Field::date('to', date('Y-m-d'), ['tpl' => 'nolabel'], ['icon' => 'calendar']) !!}
					</div>
					<div class="col-md-2">
						<button type="submit" class="btn btn-success btn-block btn-sm"><big><i class="fa fa-download"></i></big></button>
					</div>
				</div>
				{!! Form::close() !!}
			</solid-box>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<solid-box title="PROVEEDORES" color="warning" solid>
				{!! Form::open(['method' => 'POST', 'route' => 'paal.report.providers']) !!}
					{!! Field::select('provider_id', App\Provider::pluck('name', 'id')->toArray(), null, ['tpl' => 'nolabel', 'empty' => 'Seleccione un proveedor'], ['icon' => 'truck']) !!}
				<div class="row">
					<div class="col-md-5">
						{!! Field::date('from', date('Y-m-d'), ['tpl' => 'nolabel'], ['icon' => 'calendar']) !!}
					</div>
					<div class="col-md-5">
						{!! Field::date('to', date('Y-m-d'), ['tpl' => 'nolabel'], ['icon' => 'calendar']) !!}
					</div>
					<div class="col-md-2">
						<button type="submit" class="btn btn-warning btn-block btn-sm"><big><i class="fa fa-download"></i></big></button>
					</div>
				</div>
				{!! Form::close() !!}
			</solid-box>
		</div>

		<div class="col-md-6">
			<solid-box title="prueba" color="danger" solid>
				<dynamic-inputs>
					
				</dynamic-inputs>
			</solid-box>
		</div>
	</div>

@endsection