<table>
    <thead>
    <tr>
        <th>id</th>
        <th>descripción</th>
        <th>código</th>
        <th>p. menudeo</th>
        <th>p. mayoreo</th>
        <th>familia</th>
        <th>categoría</th>
    </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->code }}</td>
                <td>{{ $product->retail_price }}</td>
                <td>{{ $product->wholesale_price }}</td>
                <td>{{ $product->family }}</td>
                <td>{{ $product->category }}</td>
            </tr>
        @endforeach
    </tbody>
</table>