@extends('app')

@section('htmlheader_title')
Daftar Bank
@endsection

@section('contentheader_title')
Bank
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
		<h3 class="box-title">Mutasi Bank {{$bank->name}}</h3>
	</div>

	<div class="box-body">
	<a href="{{ url('excelDetilBank',$id) }}" role="button" class="btn btn-xs btn-primary"><i class="fa fa-cloud-download"> xls</i></a>
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
					<th>No.</th>
					<th>Tanggal</th>
					<th>Transaksi</th>
					<th>Debit</th>
					<th>Kredit</th>


				</tr>
			</thead>
			<tbody><?php $i = 0; ?>
				@foreach ($bank->transaction as $item)
				<tr><?php $i++; ?>
					<td width="7%" align="right">{{ $i }}</td>
					<td>{{ date('d-m-Y', strtotime($item->transaction_date)) }}</td>
					<td width="30%">{{ $item->transaction_code }}</td>
					<td width="20%" align="right">
						@if($item->pivot->amount > 0)
							Rp {{ number_format($item->pivot->amount, 2, ",", ".")}}
						@endif
					</td>
					<td width="20%" align="right">
						@if($item->pivot->amount <= 0)
						Rp {{ number_format($item->pivot->amount*-1, 2, ",", ".")}}
						@endif

						</td>


				</tr>


				@endforeach
			</tbody>
		</table>
	</div>
</div>


@endsection
