
                <table>
					<thead>
						<tr>
							<th>No.</th>
							<th>Nama</th>
							<th>Deksripsi</th>
							<th><center>Saldo</center></th>
							

						</tr>
					</thead>
					<tbody>
					<?php $i=0 ; $total=0; ?>
						@foreach ($items as $account)
						@if($account->group_id == 3)
						<?php $i++ ?>
						<tr>
							<td width="7%" align="right">{{ $i }}</td>
							<td>{{ $account->name }}</td>
							<td >{{ $account->notes }}</td>
							<td align="right" >
								<?php $saldo = 0; ?>
								@foreach ($account->transaction as $trans)
								<?php $saldo += $trans->pivot->amount; ?>
								@endforeach
								<?php if ($account->accountGroup->normal_balance == 'Kredit') $saldo = $saldo*-1 ?>
								
								{{ $saldo}}
								
								<?php $total+=$saldo ?>
							</td>
							
						</tr>
						@endif

						<!-- Begin Modal Delete -->
						
						<!-- End Modal Delete -->
						@endforeach
						<tr>
							<td colspan="2"></td>
							<td colspan="2" align="right"><label > Total </label> : {{ $total}}</td>
							<td></td>

						</tr>
					</tbody>
				</table>
            