<table class="table table-hover table-striped" id="data">
    <thead>
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Username</th>
        <th>Role</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $key => $item)
        @if($item->id != 1)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->email}}</td>
                <td>
                    @foreach($item->roles as $role)
                        {{$role->name}}
                    @endforeach
                </td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>