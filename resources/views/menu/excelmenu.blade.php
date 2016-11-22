<table id="item_table" class="table table-hover table-striped">
    <thead>
    <tr>
        <th>No</th>
        <th>Kode</th>
        <th>Kategori</th>
        <th>Barang</th>
        <th>Harga</th>


    </tr>
    </thead>
    <tbody>
    <?php $i = 0; ?>
    @foreach ($items as $key => $item)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{ $item->code}}</td>
            <td>{{ $item->category->name}}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->price }}</td>
        </tr>
@endforeach
    </tbody>
</table>