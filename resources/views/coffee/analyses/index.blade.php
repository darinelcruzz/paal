@extends('coffee.root')

@push('pageTitle', 'Corte mensual')

@section('content')

    <div class="row">
        <div class="col-md-6">
            <solid-box title="Comparación ventas" color="warning">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th></th>
                                <th style="text-align: center;"><small>TOTAL MENSUAL</small></th>
                                <th style="text-align: center;"><small>MES ANTERIOR</small></th>
                                <th style="text-align: center;"><small>PROMEDIO</small></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <th><small>MONTO</small></th>
                                <td style="text-align: center;">{{ number_format($ingresses->sum('amount'), 2) }}</td>
                                <td style="text-align: center;">{{ number_format($ingresses2->sum('amount'), 2) }}</td>
                                <td style="text-align: center;">{{ number_format($ingresses3->sum('amount') / date('m'), 2) }}</td>
                            </tr>
                            <tr>
                                <th><small>VENTAS</small></th>
                                <td style="text-align: center;">{{ $ingresses->count() }}</td>
                                <td style="text-align: center;">{{ $ingresses2->count() }}</td>
                                <td style="text-align: center;">{{ number_format($ingresses3->count() / date('m'), 0) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </solid-box>
        </div>
    </div>

    

@endsection
