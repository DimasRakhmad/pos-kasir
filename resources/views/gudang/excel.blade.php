<table>
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Barang</th>
					<th>Jumlah</th>
				</tr>
			</thead>
			<tbody>
			<?php $i=0; $total = 0;  ?>
				@foreach ($items as $item)
				<?php $i++; ?>
				<tr>
					<td>{{$i}}</td>
					<td>{{$item->name }}</td>
					<td>{{$item->jumlah}}</td>
					<?php $total+=$item->jumlah ?>
				</tr>
				@endforeach
				<tr>
					<td colspan="2" align="right">
						<label>Total</label>
					</td>
					<td>
						{{$total}}
					</td>
				</tr>
			</tbody>
		</table>