<table id="item_table" class="table table-hover table-striped">
    <thead>
    <tr>
        <th>No</th>
        <th>Bank</th>
        <th>Kredit</th>
        <th>Debit</th>

    </tr>
    </thead>
    <tbody>
    <?php $i = 0; ?>
    @foreach ($bank as $item)
        <?php $i++; ?>
        <tr>
            <td>{{$i}}</td>
            <td>{{ $item->name }}</td>
            <td>
                @if(!empty($item->account_kredit_id))
                    yes
                @endif
            </td>
            <td>
                @if(!empty($item->account_debit_id))
                    yes
                @endif
            </td>
        </tr>
@endforeach
    </tbody>
</table>