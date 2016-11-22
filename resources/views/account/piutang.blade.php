@section('member-tree-link')class="active" @stop
@section('piutang-link')class="active" @stop
@extends('app')

@section('htmlheader_title')
Piutang Member
@endsection

@section('contentheader_title')
Piutang Member
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
		<h3 class="box-title">List</h3>
		<div class="box-tools pull-right">
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
					<th>Piutang</th>
					<th>Jumlah</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			@foreach ($items as $key => $item)
			<?php $amount = 0; ?>
				<tr>
					<td>{{$key+1}}</td>
					<td>{{ $item->name }}</td>
					<td>
						@foreach($item->accounting as $accounting)
						<?php $amount+=$accounting->amount; ?>
						@endforeach
						Rp {{ number_format($amount, 2, ",", ".")}}
					</td>
					<td>
						<a href="{{url('pay-piutang-member',$item->id)}}" role="button" class="btn btn-xs btn-success"><i class="icon fa fa-money"></i> Bayar</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>


@endsection
