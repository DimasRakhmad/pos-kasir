<table id="item_table" class="table table-hover table-striped">
    <thead>
    <tr>
        <th>No</th>
        <th>Barang</th>
        <th>Satuan</th>
        <th>Jumlah</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($items as $key => $item)
        <?php $amount = 0; ?>
        <tr>
            <td>{{$key+1}}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->unit }}</td>
            @foreach($item->stock as $stock)
                <?php $amount+=$stock->amount; ?>
            @endforeach
            <td>{{ $amount }}</td>
        </tr>
    @endforeach
    </tbody>
</table>