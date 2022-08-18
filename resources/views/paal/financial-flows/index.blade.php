@extends('paal.root')

@push('pageTitle', 'Flujo financiero')

@section('content')
    <div class="row">
        <div class="col-md-6">

            <solid-box title="Flujo financiero" color="primary">

                <div class="table-responsive">

                <table class="table table-striped table-bordered table-hover table-condensed">
                    @php
                        $chargedIva = $egresses->sum('iva');
                        $chargedIvaCP = $egresses->whereIn('company', ['coffee', 'sanson', 'cocinaspaal'])->sum('iva');
                        $chargedIvaLP = $egresses->where('company', 'mbe')->sum('iva');

                        $paidIva = $ingresses->sum('iva');
                        $paidIvaCP = $ingresses->whereIn('company', ['coffee', 'sanson', 'cocinaspaal'])->sum('iva');
                        $paidIvaLP = $ingresses->where('company', 'mbe')->sum('iva');

                        $chargedSubtotal = $egresses->sum('subtotal');
                        $chargedSubtotalCP = $egresses->whereIn('company', ['coffee', 'sanson', 'cocinaspaal'])->sum('subtotal');
                        $chargedSubtotalLP = $egresses->where('company', 'mbe')->sum('subtotal');

                        $paidSubtotal = $ingresses->sum(function ($ingress) { return $ingress->amount - $ingress->iva; });
                        $paidSubtotalCP = $ingresses->whereIn('company', ['coffee', 'sanson', 'cocinaspaal'])->sum(function ($ingress) { return $ingress->amount - $ingress->iva; });
                        $paidSubtotalLP =$ingresses->where('company', 'mbe')->sum(function ($ingress) { return $ingress->amount - $ingress->iva; });
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
                            <td><em>IVA PAGADO</em></td>
                            <td style="text-align: right;">{{ number_format($chargedIva, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($chargedIvaCP, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($chargedIvaLP, 2) }}</td>
                        </tr>
                        <tr>
                            <td><em>IVA COBRADO</em></td>
                            <td style="text-align: right;">{{ number_format($paidIva, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($paidIvaCP, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($paidIvaLP, 2) }}</td>
                        </tr>
                        <tr>
                            <td><em>SUBTOTAL PAGADO</em></td>
                            <td style="text-align: right;">{{ number_format($chargedSubtotal - $chargedIva, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($chargedSubtotalCP - $chargedIvaCP, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($chargedSubtotalLP - $chargedIvaLP, 2) }}</td>
                        </tr>
                        <tr>
                        <td><em>SUBTOTAL COBRADO</em></td>
                            <td style="text-align: right;">{{ number_format($paidSubtotal, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($paidSubtotalCP, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($paidSubtotalLP, 2) }}</td>
                        </tr>
                    </tbody>

                </table>
                </div>

            </solid-box>
        </div>
    </div>
@endsection