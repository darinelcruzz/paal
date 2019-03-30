<table>
    <thead>
        <tr>
            <th>FI</th>
            <th>Método</th>
            <th>Cliente</th>
            <th>Referencia</th>
            <th>I.V.A.</th>
            <th>Importe</th>
        </tr>
    </thead>

    @php
        $amount = 0
    @endphp

    <tbody>
        @foreach($invoices as $invoice => $sales)
            <tr>
                <td>{{ $invoice }}</td>
                <td>{{ $sales->first()->method_name }}</td>
                <td>{{ $sales->first()->client->name }}</td>
                <td>{{ $sales->first()->reference }}</td>
                <td>{{ $sales->sum('iva') }}</td>
                <td>{{ $sales->sum('amount') }}</td>
            </tr>
            @php
                $amount += $sales->sum('amount')
            @endphp
        @endforeach
    </tbody>

    <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <th>Total</th>
            <td>{{ $amount }}</td>
        </tr>
    </tfoot>
</table>