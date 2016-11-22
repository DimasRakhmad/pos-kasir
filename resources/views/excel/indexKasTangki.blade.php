
		<table>
			<thead>
				<tr>
					<th>No.</th>
					<th>Tanggal</th>
					<th>Transaksi</th>
					<th>Debit</th>
					<th>Kredit</th>
					

				</tr>
			</thead>
			<tbody><?php $i = 0; $total =0; ?>
				@foreach ($items->transaction as $item)
				<tr><?php $i++; $total+=$item->pivot->amount;?>
					<td width="7%" align="right">{{ $i }}</td>
					<td>{{ $item->transaction_date }}</td>
					<td width="30%">{{ $item->name }}</td>
					<td width="20%">
						@if($item->pivot->amount > 0)
						{{$item->pivot->amount}}
						@endif
					</td>
					<td width="20%">
						@if($item->pivot->amount <= 0)
						{{$item->pivot->amount*-1}}
						@endif
						</td>
				</tr>
				@endforeach
				<tr>
					<th colspan="3" align="right"></th>
					<th>Total</th>
					<th>
						@if($total > 0)
						{{$total}}
						@else
						{{$total}})
						@endif
					</th>
				</tr>
			</tbody>
		</table>
