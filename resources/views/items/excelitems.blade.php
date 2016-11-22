<table id="item_table" class="table table-hover table-striped">
    <thead>
    <tr>
        <th>No</th>
        <th>Barang</th>
        <th>Satuan</th>
        <th>Deskripsi</th>

    </tr>
    </thead>
    <tbody>
    @foreach ($items as $key => $item)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->unit }}</td>
            <td>{{ $item->description }}</td>

        </tr>
@endforeach
    </tbody>
</table>