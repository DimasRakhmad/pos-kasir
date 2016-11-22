@extends('app')

@section('htmlheader_title')
Absen
@endsection

@section('contentheader_title')
Absen Karyawan
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
		<h3 class="box-title">Tanggal {{$items->tanggal}}</h3>
		
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
					<th>Nama</th>
					<th>Keterangan</th>

				</tr>
			</thead>
			<tbody>
			<?php $i=0; ?>
				@foreach ($items->absen as $item)
				<?php $i++; ?>
				<tr>
					<td>{{$i}}</td>
					<td>{{ $item->karyawan->nama }}</td>
					<td>{{$item->status}}</td>
				</tr>

				
				@endforeach

			</tbody>
		</table>
	</div>
</div>


@endsection
