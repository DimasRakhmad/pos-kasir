<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Menu</th>
        <th>Qty</th>
        <th>Amount</th>
    </tr>
    </thead>
    <tbody id="row">
    @foreach($data as $key => $value)
        <tr>
            <td> {{ $key+1 }} </td>
            <td> {{ $value->item->name }} </td>
            <td> {{ $value->qty }} </td>
            <td align="right"> {{ "Rp. " . number_format($value->total,0,",",".") }} </td>
        </tr>
    @endforeach
    </tbody>
</table>