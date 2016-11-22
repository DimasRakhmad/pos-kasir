@extends('app')

@section('htmlheader_title')
Giro
@endsection

@section('contentheader_title')
Giro
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
		<h3 class="box-title">Daftar Giro</h3>

	</div>

	<div class="box-body">
		@if(Session::has('gagal'))
		<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<i class="icon fa fa-warning"></i>
			{{ Session::get('gagal') }}
		</div>
		@endif

		@if(Session::has('sukses'))
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<i class="icon fa fa-check"></i>
			{{ Session::get('sukses') }}
		</div>
		@endif

		<table id="item_table" class="table table-hover table-striped">
			<thead>
				<tr>
					<th>No.</th>
					<th>No Giro</th>
					<th><center>Nominal</center></th>
					<th>Dibuat</th>
					<th>Efektif</th>
					<th>Bank</th>
					<th></th>

				</tr>
			</thead>
			<tbody>
			<?php $i=0 ?>
				@foreach($items as $item)
				<?php $i++ ?>
				<tr>
					<td>{{$i}}</td>
					<td>{{$item->no_giro}}</td>
					<td align="right">Rp {{ number_format($item->nominal, 2, ",", ".")}}</td>
					<td>{{ date('d-m-Y', strtotime($item->tanggal_dibuat)) }}</td>
					<td>{{ date('d-m-Y', strtotime($item->tanggal_efektif)) }}</td>
					<td>{{$item->nama_bank}}</td>
					<td>
						@if(strtotime($item->tanggal_efektif) <= strtotime('now'))
						<a href="{{url('bilyetGiro',$item->id)}}" role="button" class="btn btn-xs btn-success"><i class="icon fa fa-money"></i> Cairkan</a>
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>


@endsection
