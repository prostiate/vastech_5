<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Product Code</th>
            <th>Product Name</th>
            <th>Qty</th>
            <th>Unit</th>
            <th>Average Price</th>
            <th>Buy Price</th>
            <th>Sell Price</th>
            <th>Product Category</th>
        </tr>
    </thead>
    <tbody>
    @php $no = 1 @endphp
    @foreach($products as $product)
        <tr>
            <td style="text-align: center">{{ $no++ }}</td>
            <td>{{ $product->code }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->qty }}</td>
            <td>{{ $product->other_unit->name }}</td>
            <td>{{ $product->avg_price }}</td>
            <td>{{ $product->buy_price }}</td>
            <td>{{ $product->sell_price }}</td>
            <td>{{ $product->other_product_category->name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>