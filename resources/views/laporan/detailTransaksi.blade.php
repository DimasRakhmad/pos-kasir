@extends('app')

@section('htmlheader_title')
Daftar Barang
@endsection

@section('contentheader_title')
Barang
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
		<h3 class="box-title">Daftar Barang</h3>
		<div class="box-tools pull-right">
			<a href="{{ route('barang.create') }}" role="button" class="btn btn-xs btn-primary"><i class="fa fa-plus"> Tambah Barang</i></a>
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
Info Detil transaksi ditampilin di Modal. Tampilin Info No. Transaksi. Untuk field tabel: No, Barang, Harga Satuan, Jumlah, dan Sub Total. Di bawah, tampilkan Totalnya.
		<table id="item_table" class="table table-hover table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>No. Transaksi</th>
					<th>Satuan</th>
					<th><center> Penyusutan</center></th>
					<th></th>
					

				</tr>
			</thead>
			<tbody>
			<?php $i=0; ?>
				@foreach ($barang as $item)
				<?php $i++; ?>
				<tr>
					<td>{{$i}}</td>
					<td>{{ $item->name }}</td>
					<td>{{ $item->unit }}</td>
					<td><center>
						@if($item->shrink == 1)
						<i class="icon fa fa-check"></i>
						@endif
						</center>
					</td>
					<td>
						<a href="{{route('barang.show',$item->id)}}" role="button" class="btn btn-xs btn-primary"><i class="icon fa fa-folder-open-o"></i>Detil</a>
						<a href="{{route('barang.edit',$item->id)}}" role="button" class="btn btn-xs btn-success"><i class="icon fa fa-edit"></i> Edit</a>
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
								<center>Anda yakin akan menghapus barang {{$item->name}} ?</center>
							</div>
							<div class="modal-footer">
							<form action="{{route('barang.destroy',$item->id)}}" method="post">
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
	</div>
</div>


@endsection
