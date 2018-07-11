<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Folio</th>
        <th>Fecha</th>
        <th>Proveedor</th>
        <th>Total Com</th>
        <th>Fecha Com</th>
        <th>Subtotal</th>
        <th>Iva</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($egresses as $egress)
        <tr>
            <td>{{ $egress->id }}</td>
            <td>{{ $egress->folio }}</td>
            <td>{{ fdate($egress->buying_date, 'd M Y', 'Y-m-d') }}</td>
            <td>{{ $egress->provider->name }}</td>
            <td>{{ number_format($egress->complement_amount, 2) }}</td>
            <td>{{ fdate($egress->complement_date, 'd M Y', 'Y-m-d') }}</td>
            <td>{{ number_format($egress->amount - $egress->iva, 2) }}</td>
            <td>{{ number_format($egress->iva, 2) }}</td>
            <td>{{ number_format($egress->amount, 2) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>