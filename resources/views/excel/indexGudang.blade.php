
		<table>
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Barang</th>
					<th>Unit</th>
					<th>Jumlah</th>
					
					

				</tr>
			</thead>
			<tbody>
			<?php $i=0; ?>
				@foreach ($gudang as $item)
				<?php $i++; ?>
				<tr>
					<td>{{$i}}</td>
					<td>{{$item->barang->name }}</td>
					<td>{{$item->barang->unit }}</td>
					<td>{{$item->sum_in-$item->sum_out}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
