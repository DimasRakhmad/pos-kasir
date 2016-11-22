@extends('app')

@section('htmlheader_title')
Gudang
@endsection

@section('contentheader_title')
Gudang
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
		<h3 class="box-title">Gudang</h3>
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
					<th>Nama Barang</th>
					<th>Unit</th>
					<th>Jumlah</th>
					<th></th>
					

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
					<td>{{ number_format($item->sum_in-$item->sum_out,0,'','.')}}</td>
					
					<td>
						<a href="{{route('barang.show',$item->barang->id)}}" role="button" class="btn btn-xs btn-primary"><i class="icon fa fa-folder-open-o"></i> Detil</a>
					</td>
					
				</tr>
				@endforeach
			</tbody>
		</table>
		<a href="{{ url('excelIndexGudang') }}" role="button" class="btn btn-xs btn-primary"><i class="fa fa-cloud-download"> xls</i></a>
	</div>
</div>


@endsection
