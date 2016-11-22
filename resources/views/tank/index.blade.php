@extends('app')

@section('htmlheader_title')
Daftar Tangki
@endsection

@section('contentheader_title')
Tangki
@endsection

@section('additional_styles')
<!-- DATA TABLES -->
<link href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('additional_scripts')
<!-- DATA TABES SCRIPT -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
	$(function () {
		$('#item_table').DataTable();
	});
</script>
@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Daftar Tangki</h3>
		<div class="box-tools pull-right">
			<a href="{{ url('susut') }}" role="button" class="btn btn-xs btn-primary"><i class="fa ffa-chevron-down"> Susut</i></a>
			<a href="{{ url('transfer-tank') }}" role="button" class="btn btn-xs btn-primary"><i class="fa fa-arrows-h"> Transfer Tangki</i></a>
			<a href="{{ route('tank.create') }}" role="button" class="btn btn-xs btn-primary"><i class="fa fa-plus"> Tambah Tangki</i></a>
		</div>
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

		<table id="item_table" class="table table-hover table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Jenis Tangki</th>
					<th>Nama Tangki</th>
					<th>Supir</th>
					<th>Jumlah</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php $i=0; ?>
				@foreach ($tank as $item)
				<?php $i++; ?>
				<tr>
					<td>{{$i}}</td>
					<td>
						@if($item->stock==0)
						Jalan
						@elseif($item->stock==1)
						Gudang
						@endif
					</td>
					<td>{{ $item->name }}</td>
					<td>{{ $item->driver }}</td>
					<td>
					<?php $total=0; ?>
						@foreach($item->gudang as $gudang)
						@if($gudang->amount_in)
						<?php $total+= $gudang->amount_in ?>
					
						@elseif($gudang->amount_out)
						<?php $total-= $gudang->amount_out ?>
						@endif
						@endforeach
						{{ number_format($total,0,'','.')}}
					</td>
					<td>
						<a href="{{route('tank.show',$item->id)}}" role="button" class="btn btn-xs btn-primary"><i class="icon fa fa-folder-open-o"></i>Detil</a>
						<a href="{{route('tank.edit',$item->id)}}" role="button" class="btn btn-xs btn-success"><i class="icon fa fa-edit"></i> Edit</a>
						<a href="#" role="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modalDelete{{$item->id}}"><i class="icon fa fa-edit"></i> Delete</a>
						<a href="{{url('riwayatSusut',$item->id)}}" role="button" class="btn btn-xs btn-primary"><i class="icon fa fa-folder-open-o"></i>Riwayat Susut</a>
						@if($item->stock==0)
						<a href="{{url('uangJalan',$item->id)}}" role="button" class="btn btn-xs btn-success"><i class="icon fa fa-money"></i> Uang Jalan</a>
						@endif

						

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
								<center>Anda yakin akan menghapus barang {{$item->name}} ?</center>
							</div>
							<div class="modal-footer">
							<form action="{{route('tank.destroy',$item->id)}}" method="post">
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
				@if($total > 0)
				<!-- Begin Modal Susut -->
				<div class="modal fade" id="modalSusut{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Perhatian!!</h4>
							</div>
							<div class="modal-body">
								<center>Anda yakin akan menyusutkan {{$item->name}} ?</center>
							</div>
							<div class="modal-footer">
							<form action="{{url('susut',$item->id)}}" method="post">
							{!! csrf_field() !!}
								<input type="hidden" name="susut" value="{{$total}}">
								<button type="submit" class="btn btn-danger">Ya</button>
							</form>
								<button type="button" class="btn btn-default " data-dismiss="modal">Tidak</button>
							</div>
						</div>
					</div>
				</div>
				<!-- End Modal Susut -->
				@endif
				@endforeach
			</tbody>
		</table>
	</div>
</div>


@endsection
