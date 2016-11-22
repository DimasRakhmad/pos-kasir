@extends('app')

@section('htmlheader_title')
Kas Lancar
@endsection

@section('contentheader_title')
Kas Lancar
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
		<h3 class="box-title">Mutasi Kas Tangki</h3>
	</div>

	<div class="box-body">
	<a href="{{ url('excelIndexKasTangki') }}" role="button" class="btn btn-xs btn-primary"><i class="fa fa-cloud-download"> xls</i></a>
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
					<th>No.</th>
					<th>Tanggal</th>
					<th>Transaksi</th>
					<th>Debit</th>
					<th>Kredit</th>
					

				</tr>
			</thead>
			<tbody><?php $i = 0; $total =0; ?>
				@foreach ($items->transaction as $item)
				<tr><?php $i++; $total+=$item->pivot->amount;?>
					<td width="7%" align="right">{{ $i }}</td>
					<td>{{ $item->transaction_date }}</td>
					<td width="30%">{{ $item->name }}</td>
					<td width="20%">
						@if($item->pivot->amount > 0)
							Rp {{ number_format($item->pivot->amount, 2, ",", ".")}}
						@endif
					</td>
					<td width="20%">
						@if($item->pivot->amount <= 0)
						Rp {{ number_format($item->pivot->amount*-1, 2, ",", ".")}}
						@endif
						</td>
				</tr>
				@endforeach
				<tr>
					<th colspan="3" align="right"></th>
					<th>Total</th>
					<th>
						@if($total > 0)
						Rp {{ number_format($total, 2, ",", ".")}}
						@else
						Rp ({{ number_format($total, 2, ",", ".")}})
						@endif
					</th>
				</tr>
			</tbody>
		</table>
	</div>
</div>


@endsection
