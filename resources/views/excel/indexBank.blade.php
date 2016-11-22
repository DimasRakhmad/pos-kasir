

		<table>
			<thead>
				<tr>
					<th>No.</th>
					<th>Nama</th>
					<th>Saldo</th>
					<th></th>

				</tr>
			</thead>
			<tbody><?php $i = 0; ?>
			@foreach ($items as $item)
			<?php $i++ ?>
				<tr>
					<td width="7%" align="right">{{ $i }}</td>
					<td width="30%">
						@if($item->group_id==10)
						Bank 
						@endif
						{{ $item->name }}
					</td>
					<td align="right" width="25%">
						<?php $saldo = 0; ?>
						@foreach ($item->transaction as $trans)
						<?php $saldo += $trans->pivot->amount; ?>
						@endforeach
						<?php if ($item->accountGroup->normal_balance == 'Kredit') $saldo = $saldo*-1 ?>
						
						{{ $saldo }}
						
					</td>
					
				</tr>

				
				
				@endforeach
			</tbody>
		</table>
		