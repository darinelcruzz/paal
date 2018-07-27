<table>
    <thead>
    <tr>
        <th>Proveedor</th>
        <th>Folio</th>
        <th>Fecha</th>
        <th>Empresa</th>
        <th>Total Com</th>
        <th>Fecha Com</th>
        <th>Subtotal</th>
        <th>Iva</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($egresses as $provider_id => $egresses_group)
        @foreach($egresses_group as $egress)
            <tr>
                <td>{{ App\Provider::find($provider_id)->name }}</td>
                <td>{{ $egress->folio }}</td>
                <td>{{ fdate($egress->emission, 'd M Y', 'Y-m-d') }}</td>
                <td>{{ $egress->company }}</td>
                <td>{{ number_format($egress->complement_amount, 2) }}</td>
                <td>{{ fdate($egress->complement_date, 'd M Y', 'Y-m-d') }}</td>
                <td>{{ number_format($egress->amount - $egress->iva, 2) }}</td>
                <td>{{ number_format($egress->iva, 2) }}</td>
                <td>{{ number_format($egress->amount, 2) }}</td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>