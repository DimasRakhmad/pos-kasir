<table id="item_table" class="table table-hover table-striped">
    <thead>
    <tr>
        <th>No</th>
        <th>Area</th>
        <th>Code</th>
        <th>Name</th>
        <th>Status</th>


    </tr>
    </thead>
    <tbody>
    @foreach ($items as $key => $item)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$item->area->name}}</td>
            <td>{{ $item->code }}</td>
            <td>{{ $item->name }}</td>
            <td>{{$item->status}}</td>
        </tr>
@endforeach
    </tbody>
</table>