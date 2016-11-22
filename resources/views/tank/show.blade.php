@extends('app')

@section('htmlheader_title')
Riwayat Tangki
@endsection

@section('contentheader_title')
Tangki
@endsection

@section('additional_styles')

@endsection

@section('additional_scripts')
@endsection

@section('main-content')
<?php $total=0; $penjualan = 0; $pembelian =0; ?>
						@foreach($tank->gudang as $gudang)
						@if($gudang->amount_in)
						<?php $total+= $gudang->amount_in; $pembelian+=($gudang->amount_in*$gudang->unit_price);   ?>
						
						@elseif($gudang->amount_out)
						<?php $total-= $gudang->amount_out; $penjualan+=($gudang->amount_out*$gudang->unit_price);  ?>
						@endif
						@endforeach

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Riwayat {{$tank->name}} - Supir : {{$tank->driver}} - Jumlah : {{ number_format($total,0,'','.')}} Liter</h3>
	</div>

	<div class="box-body">
		@if(Session::has('merah'))
		<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<i class="icon fa fa-warning"></i>
			{{ Session::get('merah') }}
		</div>
		@endif

		@if(Session::has('hijau'))
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<i class="icon fa fa-check"></i>
			{{ Session::get('hijau') }}
		</div>
		@endif
		<div class="row">
			<div class="col-md-4"><label>Penjualan :</label> Rp {{ number_format($penjualan, 2, ",", ".")}}</div>
			<div class="col-md-4"><label>Pembelian :</label> Rp {{ number_format($pembelian, 2, ",", ".")}}</div>
			<?php $labarugi = $penjualan - $pembelian; ?>
			<div class="col-md-4"><label>Laba/Rugi :</label> @if($labarugi < 0) Rp ({{ number_format($labarugi*-1, 2, ",", ".")}}) @else  Rp {{ number_format($labarugi, 2, ",", ".")}} @endif</div>
		</div>
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Sumber/Tujuan</th>
					<th>Masuk</th>
					<th>Keluar</th>
					<th>Harga</th>
					<th></th>
					

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
						{{ number_format($item->amount_in,0,'','.')}}
					</td>
					
					<td>
					{{ number_format($item->amount_out,0,'','.')}}
						
						
					</td>
					<td>Rp {{ number_format($item->unit_price, 2, ",", ".")}}</td>
					<td>
						<a href="{{route('gudang.edit',$item->id)}}" role="button" class="btn btn-xs btn-success"><i class="icon fa fa-edit"></i> Edit</a>
						<a href="#" role="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modalDelete{{$item->id}}"><i class="icon fa fa-edit"></i> Delete</a>
					</td>
					
				</tr>

				<!-- Begin Modal Delete -->
				<div class="modal fade" id="modalDelete{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Perhatian!!</h4>
							</div>
							<div class="modal-body">
								<center>Anda yakin akan menghapus data ini ?</center>
							</div>
							<div class="modal-footer">
							<form action="{{route('gudang.destroy',$item->id)}}" method="post">
							<input type="hidden" name="_method" value="delete">
							{!! csrf_field() !!}
								<button type="submit" class="btn btn-danger">Ya</button>
							</form>
								<button type="button" class="btn btn-default " data-dismiss="modal">Tidak</button>
							</div>
						</div>
					</div>
				</div>
				<!-- End Modal Delete -->
				@endforeach
			</tbody>
		</table>
		<a href="{{ url('excelDetilTank',$id) }}" role="button" class="btn btn-xs btn-primary"><i class="fa fa-cloud-download"> xls</i></a>
	</div>
</div>


@endsection
