<table class="table table-striped table-condensed">
    <thead>
        <tr class="headings btn-dark">
            <th class="column-title text-left">Product Code</th>
            <th class="column-title text-left">Product Name</th>
            <th class="column-title text-left">Qty</th>
            <th class="column-title text-center">Buffer Qty</th>
            <th class="column-title text-left">Units</th>
            <th class="column-title text-right" style="width: 150px">Average Cost</th>
            <th class="column-title text-right" style="width: 150px">Value</th>
        </tr>
    </thead>
    <tbody>
        <?php $total_val = 0 ?>
        <?php $grand_total_val = 0 ?>
        @foreach($products as $a)
        <tr>
            <td>
                <a>{{$a->code}}</a>
            </td>
            <td>
                <a href="/products/{{$a->id}}">{{$a->name}}</a>
            </td>
            <td>
                <a>{{$a->qty}}</a>
            </td>
            <td class="text-center">
                <a>-</a>
            </td>
            <td>
                <a>{{$a->other_unit->name}}</a>
            </td>
            <td class="text-right">
                <a>@number($a->avg_price)</a>
            </td>
            <td class="text-right">
                <?php $total_val = $a->avg_price * $a->qty ?>
                <a>@number($total_val)</a>
            </td>
        </tr>
        <?php $grand_total_val += $total_val ?>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="6" style="text-align: right"><strong>Total Value</strong></th>
            <th class="text-right"><strong>@number($grand_total_val)</strong></th>
        </tr>
    </tfoot>
</table>