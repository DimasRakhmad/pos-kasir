<table id="item_table" class="table table-hover table-striped">
    <thead>
    <tr>
        <th>No</th>
        <th>Nama Kategori</th>
        <th>Deskripsi</th>


    </tr>
    </thead>
    <tbody>
    <?php $i=0; ?>
    @foreach ($category as $item)
        <?php $i++; ?>
        <tr>
            <td>{{$i}}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->description }}</td>
        </tr>
@endforeach
    </tbody>
</table>