
<?php $total=0; $penjualan = 0; $pembelian =0; ?>
						@foreach($tank->gudang as $gudang)
						@if($gudang->amount_in)
						<?php $total+= $gudang->amount_in; $pembelian+=($gudang->amount_in*$gudang->unit_price);   ?>
						
						@elseif($gudang->amount_out)
						<?php $total-= $gudang->amount_out; $penjualan+=($gudang->amount_out*$gudang->unit_price);  ?>
						@endif
						@endforeach

		<table>
			<tr>
				<td colspan="2">Penjualan : {{$penjualan}}</td>
				<td colspan="2">Pembelian : {{$pembelian}}</td>
				<?php $labarugi = $penjualan - $pembelian; ?>
				<td colspan="2">Laba/Rugi :  @if($labarugi < 0) ({{ $labarugi*-1}}) @else  {{ $labarugi}} @endif</td>
			</tr>
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Sumber/Tujuan</th>
					<th>Masuk</th>
					<th>Keluar</th>
					<th>Harga</th>
					
					

				</tr>
			</thead>
			<tbody>
			<?php $i=0; ?>
				@foreach ($tank->gudang as $item)
				<?php $i++; ?>
				<tr>
					<td>{{$i}}</td>
					<td>{{ date('d F, Y', strtotime($item->created_at)) }}</td>
					<td>
						@if($item->type=="Susut")
						Susut
						@elseif($item->type=="Transfer ke"||$item->type=="Transfer dari")
							@if($item->tank)
							{{$item->tank->name}}
							@else
							{{$item->notes}}
							@endif
						@else
						@if($item->partner) {{$item->partner->name}} @else - @endif
						@endif
					</td>
					<td>
						{{ $item->amount_in}}
					</td>
					
					<td>
					{{ $item->amount_out}}
						
						
					</td>
					<td>{{$item->unit_price}}</td>
					
				</tr>

				
				@endforeach
			</tbody>
		</table>
