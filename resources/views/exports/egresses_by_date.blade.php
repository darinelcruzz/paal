<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Folio</th>
        <th>Proveedor</th>
        <th>Compañía</th>
        <th>Total</th>
        <th>Iva</th>
        <th>Fecha</th>
    </tr>
    </thead>
    <tbody>
    @foreach($egresses as $egress)
        <tr>
            <td>{{ $egress->id }}</td>
            <td>{{ $egress->folio }}</td>
            <td>{{ $egress->provider->name }}</td>
            <td>{{ $egress->company }}</td>
            <td>{{ number_format($egress->amount, 2) }}</td>
            <td>{{ number_format($egress->iva, 2) }}</td>
            <td>{{ fdate($egress->buying_date, 'd M Y', 'Y-m-d') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>