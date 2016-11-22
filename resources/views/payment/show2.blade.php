@extends('app')

@section('htmlheader_title')
{{ $items->name }}
@endsection

@section('contentheader_title')
{{ $items->name }}
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
		<h3 class="box-title">Bank {{$items->name}}</h3>
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

		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>No.</th>
					<th>Tanggal</th>
					<th>Transaksi</th>
					<th>Deskripsi</th>
					<th>Debit</th>
					<th>Kredit</th>


				</tr>
			</thead>
			<tbody><?php $i = 0; $total =0; ?>
				@foreach ($items->transaction as $item)
				<tr><?php $i++; $total+=$item->pivot->amount;?>
					<td width="5%" align="right">{{ $i }}</td>
					<td widht="15%">{{ $item->transaction_date }}</td>
					@if ($item->partner_id == null)
					<td width="15%">{{ $item->transaction_code }}</td>
					@else
					<td width="15%"><a href="#" role="button" data-toggle="modal" data-target="#modalDetil{{$item->id}}">{{ $item->transaction_code }}</a></td>
					@endif

					<td width="25%">{{ $item->name }} @if($item->pivot->keterangan) ({{$item->pivot->keterangan}})@endif</td>
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
				<!-- Modal -->
				<div class="modal fade" id="modalDetil{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">No. Transaksi :</h4>
							</div>
							<div class="modal-body">
							<div class="row">
								<div class="col-md-2"><label>No</label></div>
								<div class="col-md-4"><label>Barang</label></div>
								<div class="col-md-2"><label>Harga Satuan</label></div>
								<div class="col-md-2"><label>Jumlah</label></div>
								<div class="col-md-2"><label>Sub Total</label></div>

							</div>
								<?php $j=0; ?>
								@foreach($item->transactionDetails as $detil)
								<?php $j++ ?>
							<div class="row">
								<div class="col-md-2">{{$j}}</div>
								<div class="col-md-4">
									@if($detil->barang)
									{{$detil->barang->name}}
									@endif
								</div>
								<div class="col-md-2">
									@if($detil->gudang)
									Rp {{ number_format($detil->gudang->unit_price, 2, ",", ".")}}

									@endif</div>
								<div class="col-md-2">
									@if($detil->gudang)
										@if($detil->gudang->amount_in)
									{{ number_format($detil->gudang->amount_in,0,'','.')}}
										@elseif($detil->gudang->amount_out)
									{{ number_format($detil->gudang->amount_out,0,'','.')}}
										@endif
									@endif
								</div>
								<div class="col-md-2">
									@if($detil->gudang)

									Rp {{ number_format($detil->gudang->price, 2, ",", ".")}}

									@endif

								</div>
							</div>
								@endforeach

							</div>
						</div>
					</div>
				</div>
				@endforeach
				<!-- End Modal -->
				<tr>
					<th colspan="3" align="right"></th>
					<th>Total</th>
					<th>
						@if($total > 0)
						Rp {{ number_format($total, 2, ",", ".")}}
						@else
						Rp ({{ number_format($total*-1, 2, ",", ".")}})
						@endif
					</th>
				</tr>
			</tbody>
		</table>
	</div>
</div>


@endsection
