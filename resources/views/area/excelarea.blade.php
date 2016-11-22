<table id="item_table" class="table table-hover table-striped">
    <thead>
    <tr>
        <th>No</th>
        <th>Name</th>


    </tr>
    </thead>
    <tbody>
    @foreach ($items as $key => $item)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{ $item->name }}</td>
        </tr>
@endforeach
    </tbody>
</table>