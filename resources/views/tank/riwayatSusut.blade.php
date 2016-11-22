@extends('app')

@section('htmlheader_title')
Riwayat Susut Tangki
@endsection

@section('contentheader_title')
Tangki
@endsection

@section('additional_styles')

@endsection

@section('additional_scripts')
@endsection

@section('main-content')


<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Riwayat Susut {{$tank->name}} - Supir : {{$tank->driver}} </h3>
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

		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Jumlah Susut</th>
					<th></th>

				</tr>
			</thead>
			<tbody>
			<?php $i=0; ?>
				@foreach ($tank->gudang as $item)
				@if($item->type == "Susut")
				<?php $i++; ?>
				<tr>
					<td>{{$i}}</td>
					<td>{{ date('d F, Y', strtotime($item->created_at)) }}</td>
					<td>
						{{ number_format($item->amount_out,0,'','.')}}
					</td>
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
							<form action="{{url('hapus-susust',$item->id)}}" method="post">
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
				@endif
				@endforeach
			</tbody>
		</table>
	</div>
</div>


@endsection
