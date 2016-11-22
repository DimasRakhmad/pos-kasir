

		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>No.</th>
					<th>Tanggal</th>
					<th>Transaksi</th>
					<th>Deskripsi</th>
					<th>Debit</th>
					<th>Kredit</th>


				</tr>
			</thead>
			<tbody><?php $i = 0; $total =0; ?>
				@foreach ($items->transaction as $item)
				<tr><?php $i++; $total+=$item->pivot->amount;?>
					<td width="5%" align="right">{{ $i }}</td>
					<td widht="15%">{{ $item->transaction_date }}</td>
					@if ($item->partner_id == null)
					<td width="15%">{{ $item->transaction_code }}</td>
					@else
					<td width="15%"><a href="#" role="button" data-toggle="modal" data-target="#modalDetil{{$item->id}}">{{ $item->transaction_code }}</a></td>
					@endif

					<td width="25%">{{ $item->name }} @if($item->pivot->keterangan) ({{$item->pivot->keterangan}})@endif</td>
					<td width="20%" align="right">
						@if($item->pivot->amount > 0)
						 {{$item->pivot->amount}}
						@endif
					</td>
					<td width="20%" align="right">
						@if($item->pivot->amount <= 0)
						{{$item->pivot->amount*-1}}
						@endif
						</td>
				</tr>
				
				@endforeach
				<!-- End Modal -->
				<tr>
					
					<th colspan="2">Total</th>
					<th colspan="3">
						@if($total > 0)
						{{ $total}}
						@else
						{{$total*-1}}
						@endif
					</th>
					<th align="right"></th>
				</tr>
			</tbody>
		</table>
