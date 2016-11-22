
		<table >
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Gaji Pokok</th>
					<th>Upah Lembur</th>
					<th>Uang Makan</th>
					<th>Potongan Absen</th>
					<th>Potongan Kasbon</th>
					<th>Total Gaji</th>
					

				</tr>
			</thead>
			<tbody>
			<?php $i=0; ?>
				@foreach ($items as $item)
				<?php $i++ ?>
				<tr>
					<td>{{$i}}</td>
					<td>{{ $item->karyawan->nama }}</td>
					<td>{{ $item->gaji_pokok}}</td>
					<td>{{ $item->upah_lembur}}</td>
					<td>{{ $item->uang_makan}}</td>
					<td>{{ $item->potongan_absen}}</td>

					<td>{{ $item->potongan_kasbon}}</td>

					<td>{{ $item->total_gaji}}</td>
					

				</tr>

				
				@endforeach
			</tbody>
		</table>
