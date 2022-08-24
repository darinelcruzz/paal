@extends('paal.root')

@push('pageTitle', 'Flujo financiero')

@section('content')
    <div class="row">
        <div class="col-md-6">

            <solid-box title="Flujo financiero" color="primary">

                <div class="table-responsive">

                <table class="table table-striped table-bordered table-hover table-condensed">
                    @php
                        $charged = $egresses->sum($type);
                        $chargedCP = $egresses->whereIn('company', ['coffee', 'sanson', 'cocinaspaal'])->sum($type);
                        $chargedLP = $egresses->where('company', 'mbe')->sum($type);

                        $charged4 = $egresses->where('iva_type', '4%')->sum($type);
                        $charged4CP = $egresses->where('iva_type', '4%')->whereIn('company', ['coffee', 'sanson', 'cocinaspaal'])->sum($type);
                        $charged4LP = $egresses->where('iva_type', '4%')->where('company', 'mbe')->sum($type);

                        $charged16 = $egresses->where('iva_type', '16%')->sum($type);
                        $charged16CP = $egresses->where('iva_type', '16%')->whereIn('company', ['coffee', 'sanson', 'cocinaspaal'])->sum($type);
                        $charged16LP = $egresses->where('iva_type', '16%')->where('company', 'mbe')->sum($type);

                        $paid = $ingresses->sum($type);
                        $paidCP = $ingresses->whereIn('company', ['coffee', 'sanson', 'cocinaspaal'])->sum($type);
                        $paidLP = $ingresses->where('company', 'mbe')->sum($type);

                        $paid16 = $ingresses->sum($type);
                        $paid16CP = $ingresses->whereIn('company', ['coffee', 'sanson', 'cocinaspaal'])->sum($type);
                        $paid16LP = $ingresses->where('company', 'mbe')->sum($type);
                    @endphp
                    <thead>
                        <tr>
                            <th><small>CONCEPTO</small></th>
                            <th style="text-align: right;"><small>TOTAL</small></th>
                            <th style="text-align: right;"><small>COCINAS</small></th>
                            <th style="text-align: right;"><small>LOGÍSTICA</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td><em>{{ strtoupper($type) }} PAGADO</em></td>
                            <td style="text-align: right;">{{ number_format($charged, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($chargedCP, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($chargedLP, 2) }}</td>
                        </tr>
                        <tr>
                            <td><em>4%</em></td>
                            <td style="text-align: right;">{{ number_format($charged4, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($charged4CP, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($charged4LP, 2) }}</td>
                        </tr>
                        <tr>
                            <td><em>16%</em></td>
                            <td style="text-align: right;">{{ number_format($charged16, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($charged16CP, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($charged16LP, 2) }}</td>
                        </tr>
                        <tr>
                            <td><em>{{ strtoupper($type) }} COBRADO</em></td>
                            <td style="text-align: right;">{{ number_format($paid, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($paidCP, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($paidLP, 2) }}</td>
                        </tr>
                        <tr>
                            <td><em>16%</em></td>
                            <td style="text-align: right;">{{ number_format($paid16, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($paid16CP, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($paid16LP, 2) }}</td>
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th><small>DIFERENCIA</small></th>
                            <td style="text-align: right;">{{ number_format($paid - $charged, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($paidCP - $chargedCP, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($paidLP - $chargedLP, 2) }}</td>
                        </tr>
                    </tfoot>

                </table>
                </div>

            </solid-box>
        </div>
    </div>
@endsection