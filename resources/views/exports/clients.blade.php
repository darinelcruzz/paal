<table>
    <thead>
    <tr>
        <th>id</th>
        <th>nombre</th>
        <th>r.f.c.</th>
        <th>correo</th>
        <th>teléfono</th>
        <th>dirección</th>
        <th>c.p.</th>
        <th>ciudad</th>
        <th>estado</th>
        <th>envío</th>
        <th>c.p.</th>
        <th>ciudad</th>
        <th>estado</th>
    </tr>
    </thead>
    <tbody>
        @foreach($clients as $client)
            <tr>
                <td>{{ $client->id }}</td>
                <td>{{ $client->name }}</td>
                <td>{{ $client->rfc }}</td>
                <td>{{ $client->email }}</td>
                <td>{{ $client->phone }}</td>
                <td>{{ $client->address }}</td>
                <td>{{ $client->postcode }}</td>
                <td>{{ $client->city }}</td>
                <td>{{ $client->state }}</td>
                @foreach($client->addresses as $address)
                <td>{{ $address->street . ' ' . $address->street_number . ', col.' . $address->district }}</td>
                <td>{{ $address->postcode }}</td>
                <td>{{ $address->city }}</td>
                <td>{{ $address->state }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>