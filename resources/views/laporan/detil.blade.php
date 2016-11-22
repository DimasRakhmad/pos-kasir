@extends('app')

@section('htmlheader_title')
Rincian 
@endsection

@section('contentheader_title')
Rincian {{$transaction->name}}
@endsection

@section('additional_styles')
	<link href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('additional_scripts')

	<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
	
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
	$(function () {
		$('#akun').DataTable();
	});
</script>
@endsection


@section('main-content')
<div class="box box-primary">
	<div class="box-body">
		
		@if($items == NULL)
		<div class="alert alert-warning alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<i class="icon fa fa-warning"></i>
			Opps! Maaf, tidak ada data.
		</div>
		@else
		<table  class="table table-hover">
			<thead>
				<tr>
					<th>No.</th>
					<th>Barang</th>
					<th>Harga Satuan</th>
					<th>Jumlah</th>
					<th>Sub Total</th>
				</tr>
			</thead>
			<tbody>
				<?php $saldo=0; $i=0; ?>
				@foreach($items as $item)
				<tr>
				<?php $saldo+=$item->price; $i++; ?>
					<td>{{$i}}</td>
					<td>{{ $item->nama }}</td>
					<td>Rp {{ number_format($item->unit_price, 2, ",", ".")}}
					</td>
					<td>
						@if($item->amount_out)
						{{ number_format($item->amount_out,0,'','.')}}
						
						@endif
						@if($item->amount_in)
						{{ number_format($item->amount_in,0,'','.')}}
						@endif
					</td>
					<td>
						Rp {{ number_format($item->price, 2, ",", ".")}}
					</td>
				</tr>
				@endforeach
				
				<tr>
					<td colspan="4" align="right"><b>Total :</b></td>
					<td align="left"><b>Rp {{ number_format($saldo, 2, ",", ".")}}</b></td>
				</tr>
				
			</tbody>
			</table>
			
					
			
			@endif
	</div>
</div>

@endsection
