            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Menu</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Total</th>                    
                    </tr>
                </thead>
                <tbody id="row">
                    @foreach($trans->detail as $key => $value)
                    <tr>
                        <td> {{ $key+1 }} </td>
                        <td> {{ $value->item ? $value->item->name : $value->notes }} </td>
                        <td> {{ $value->qty }} </td>
                        <td> {{ "Rp. " . number_format($value->subtotal,0,",",".") }} </td>
                        <td> {{ "Rp. " . number_format($value->discount,0,",",".") }} </td>
                        <td> {{ "Rp. " . number_format($value->total,0,",",".") }} </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>