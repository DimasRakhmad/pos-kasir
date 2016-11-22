<table>
    <tr>
        <td>Dine In : </td><td>{{ $dine}}</td>
    </tr>
    <tr>
        <td>Take Away : </td><td>{{ $take}}</td>
    </tr>
    <tr>
        <td>Delivery : </td><td>{{ $deliv}}</td>
    </tr>
    <tr>
        <th>No</th>
        <th>Transaction Code</th>
        <th>Order Type</th>
        <th>Pay Type</th>
        <th>Amount</th>
        <th>Time</th>
    </tr>
    </thead>
    <tbody id="row">
    @foreach($trans as $key => $value)
        <tr>
            <td> {{ $key+1 }} </td>
            <td> {{ $value->code }} </td>
            <td> {{ $value->sales->order_type }} </td>
            <td> {{ $value->sales->pay_type }} </td>
            <td> {{ "Rp. " . number_format($value->total,0,",",".") }} </td>
            <td> {{ date('d F Y H:i:s',strtotime($value->created_at)) }} </td>
        </tr>
    @endforeach
    </tbody>
</table>