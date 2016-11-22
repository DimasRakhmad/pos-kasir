@section('account-tree-link')class="active" @stop
@section('account-link')class="active" @stop
@extends('app')

@section('htmlheader_title')
Account
@endsection

@section('contentheader_title')
Account
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

		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Deskripsi</th>
					<th>Debit</th>
					<th>Kredit</th>
				</tr>
			</thead>
			<tbody>
			<?php $kredit = 0; $debit = 0; ?>
			@foreach ($items->accounting as $key => $item)
			<?php $amount = 0; ?>
				<tr>
					<td>{{$key+1}}</td>
					<td>{{ $item->account->name }}</td>
					<td align="right">
						@if ($item->amount >=0)
							<?php $debit += $item->amount ?>
							Rp {{ number_format($item->amount, 2, ",", ".")}}
						@endif
					</td>
					<td align="right">
						@if($item->amount < 0)
						<?php $kredit += $item->amount ?>
						 Rp {{ number_format($item->amount*-1, 2, ",", ".")}}
						@endif
					</td>
				</tr>

				@endforeach
				<tr>
					<td colspan="2" align="right"><b>Total</b></td>
					<td align="right"><b>Rp {{ number_format($debit, 2, ",", ".")}}</b></td>
					<td align="right"><b>Rp {{ number_format($kredit*-1, 2, ",", ".")}}</b></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>


@endsection
