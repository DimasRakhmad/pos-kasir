<table>
	<tr>
		<th>Tanggal</th>
		<th>Kode Invoice</th>
		<th>Supplier</th>
		<th>Nama Barang</th>
		<th>Kuantitas</th>
		<th>Harga per Unit</th>
		<th>AMT</th>
		<th>Total AMT</th>
	</tr>
	<?php $total=0; $t=count($items)-1;?>

	@foreach($items as $key => $item )
	<tr>
		<td>

			@if($key != 0)
			@if($items[$key]->transaction_code != $items[$key-1]->transaction_code)
			{{$item->transaction_date}}
			@endif
			@else
			{{$item->transaction_date}}
			@endif
			</td>

		<td>
			@if($key != 0)
			@if($items[$key]->transaction_code != $items[$key-1]->transaction_code)
			{{$item->transaction_code}}
			@endif
			@else
			{{$item->transaction_code}}
			@endif
		</td>
		<td>
			@if($key != 0)
			@if($items[$key]->transaction_code != $items[$key-1]->transaction_code)
			{{$item->name}}
			@endif
			@else
			{{$item->name}}
			@endif
			</td>
		<td>{{$item->barang}}</td>
		<td>

			{{$item->amount}}

		</td>
		<td>{{$item->unit_price}}</td>
		<td>{{$item->price}}</td>

		<td>

			@if($key != $t)
			@if($items[$key]->transaction_code == $items[$key+1]->transaction_code)
			<?php $total=0; ?>
			<?php $total+=$item->price ?>
			@else
			<?php $total+=$item->price ?>
			{{$total}}
			<?php $total=0; ?>
			@endif
			@else
			<?php $total+=$item->price ?>
			{{$total}}
			@endif
		</td>
	</tr>
	@endforeach
</table>
