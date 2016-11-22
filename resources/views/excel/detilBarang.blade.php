<table>
		@if($barang->shrink==1)
		<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Tangki</th>
					<th>Masuk</th>
					<th>Keluar</th>
					<th>Harga Satuan</th>
					

				</tr>
			</thead>
			<tbody>
			<?php $i=0; ?>
				@foreach ($barang->gudang as $item)
				@if($item->type != "Susut dari")
				<?php $i++; ?>
				<tr>
					<td>{{$i}}</td>
					<td>{{ date('d F, Y', strtotime($item->created_at)) }}</td>
					<td>
						@if($item->tank)
							{{$item->tank->name}}
						@endif
						@if($item->type=="Susut")
							(Susut)
						@elseif($item->type=="Transfer ke" || $item->type=="Transfer dari")
							(Transfer Tangki)
						@else
							@if($item->partner)
								@if ($item->amount_in == null)
									ke
								@else
									dari
								@endif
								{{$item->partner->name}}
							@else
								-
							@endif
						@endif
					</td>
					<td>
						{{$item->amount_in}}
					</td>

					<td>
					{{$item->amount_out}}


					</td>
					<td>{{ $item->unit_price}}</td>
					

				</tr>

				
				@endif
				@endforeach
			</tbody>
		@else
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Masuk</th>
					<th>Keluar</th>
					<th>Harga</th>


				</tr>
			</thead>
			<tbody>
			<?php $i=0; ?>
				@foreach ($barang->gudang as $item)
				<?php $i++; ?>
				<tr>
					<td>{{$i}}</td>
					<td>{{ date('d F, Y', strtotime($item->created_at)) }}</td>
					<td>
						{{$item->amount_in}}

					</td>
					<td>
					{{$item->amount_out}}

					</td>
					<td>{{$item->unit_price}}</td>
					

				</tr>

				@endforeach
			</tbody>
			@endif
		</table>