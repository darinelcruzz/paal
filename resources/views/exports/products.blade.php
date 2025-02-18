<table>
    <thead>
    <tr>
        <th>id</th>
        <th>descripción</th>
        <th>código</th>
        <th>p. menudeo</th>
        <th>p. mayoreo</th>
        <th>descuento max</th>
        <th>familia</th>
        <th>categoría</th>
        <th>tipo</th>
        <th>estado</th>
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
                <td>{{ $product->maximum_discount }}</td>
                <td>{{ $product->family }}</td>
                <td>{{ $product->category }}</td>
                <td>{{ $product->type }}</td>
                <td>{{ $product->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>