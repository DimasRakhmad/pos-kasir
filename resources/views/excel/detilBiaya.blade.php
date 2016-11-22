

		<table>
			<thead>
				<tr>
					<th>No.</th>
					<th>Tanggal</th>
					<th>Deksripsi</th>
					<th><center>Jumlah</center></th>


				</tr>
			</thead>
			<tbody>
			<?php $i=0 ; $total=0; ?>
				@foreach ($items->transaction as $item)
				<?php $i++ ?>
				<tr>
					<td width="7%" align="right">{{ $i }}</td>
					<td>{{ date('d-m-Y', strtotime($item->transaction_date)) }}</td>
					<td>
						{{ $item->name }}
						@if ($item->pivot->keterangan != null)
						({{ $item->pivot->keterangan }})
						@endif
					</td>
					<td align="right" >

					
						{{$item->pivot->amount}}
						
						<?php $total+=$item->pivot->amount ?>
					</td>

				</tr>

				@endforeach
				<tr>
					<td colspan="2"></td>
					<td colspan="2" align="right"><label > Total </label> : {{$total}}</td>

				</tr>
			</tbody>
		</table>

