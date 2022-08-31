@extends('paal.root')

@push('pageTitle', 'Flujo financiero')

@section('content')
    <div class="row">
        <div class="col-md-6">

            <solid-box title="Flujo financiero" color="primary">

                <div class="table-responsive">

                <table class="table table-striped table-bordered table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><small>CONCEPTO</small></th>
                            <th style="text-align: right;"><small>TOTAL</small></th>
                            <th style="text-align: right;"><small>COCINAS</small></th>
                            <th style="text-align: right;"><small>LOGÍSTICA</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($categories as $category => $subtotals)
                        <tr>
                            <td><em>{{ strtoupper($category != '' ? $category: 'NO ASIGNADO') }}</em></td>
                            <td style="text-align: right;">{{ number_format($subtotals->sum(function ($subtotal) { return $subtotal->amount - $subtotal->iva;}), 2) }}</td>
                            <td style="text-align: right;">{{ number_format($subtotals->where('company', '!=', 'mbe')->sum(function ($subtotal) { return $subtotal->amount - $subtotal->iva;}), 2) }}</td>
                            <td style="text-align: right;">{{ number_format($subtotals->where('company', 'mbe')->sum(function ($subtotal) { return $subtotal->amount - $subtotal->iva;}), 2) }}</td>
                        </tr>
                        @endforeach

                        <tr>
                            <th style="text-align: right;"><small>SUMA</small></th>
                            <th style="text-align: right;">{{ number_format($categories->sum(function ($ctg) { return $ctg->sum('amount') - $ctg->sum('iva');}), 2) }}</th>
                            <th style="text-align: right;">
                                {{ number_format($categories->sum(function ($ctg) { return $ctg->where('company', '!=', 'mbe')->sum(function ($egr) { return $egr->amount - $egr->iva;});}), 2) }}
                            </th>
                            <th style="text-align: right;">
                                {{ number_format($categories->sum(function ($ctg) { return $ctg->where('company', 'mbe')->sum(function ($egr) { return $egr->amount - $egr->iva;});}), 2) }}
                            </th>
                        </tr>

                        @foreach($groups as $group => $subtotals)
                        <tr>
                            <td><em>{{ strtoupper($group != '' ? $group: 'NO ASIGNADO') }}</em></td>
                            <td style="text-align: right;">{{ number_format($subtotals->sum(function ($subtotal) { return $subtotal->amount - $subtotal->iva;}), 2) }}</td>
                            <td style="text-align: right;">{{ number_format($subtotals->where('company', '!=', 'mbe')->sum(function ($subtotal) { return $subtotal->amount - $subtotal->iva;}), 2) }}</td>
                            <td style="text-align: right;">{{ number_format($subtotals->where('company', 'mbe')->sum(function ($subtotal) { return $subtotal->amount - $subtotal->iva;}), 2) }}</td>
                        </tr>
                        @endforeach

                        <tr>
                            <th style="text-align: right;"><small>SUMA</small></th>
                            <th style="text-align: right;">{{ number_format($groups->sum(function ($group) { return $group->sum('amount') - $group->sum('iva');}), 2) }}</th>
                            <th style="text-align: right;">
                                {{ number_format($groups->sum(function ($grp) { return $grp->where('company', '!=', 'mbe')->sum(function ($egr) { return $egr->amount - $egr->iva;});}), 2) }}
                            </th>
                            <th style="text-align: right;">
                                {{ number_format($groups->sum(function ($grp) { return $grp->where('company', 'mbe')->sum(function ($egr) { return $egr->amount - $egr->iva;});}), 2) }}
                            </th>
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th><small>DIFERENCIA</small></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>

                </table>
                </div>

            </solid-box>
        </div>
    </div>
@endsection