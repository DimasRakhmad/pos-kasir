@extends('app')

@section('htmlheader_title')
@if($items->group_id==7)
Hutang
@elseif($items->group_id==8)
Piutang
@endif
@endsection

@section('contentheader_title')
{{ $items->name }}
@endsection

@section('additional_styles')
	<link href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
	<style>
	.besar
	{
	    width: 700px;

	}

	.besar .modal-body {
	    max-height: 525px;
	}
	</style>
@endsection

@section('additional_scripts')

<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
	$(function () {
		$('#items').DataTable();
	});
</script>
@endsection


@section('main-content')
<div class="box box-primary">
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

		<table  class="table table-hover">
			<thead>
				<tr>
					<th>Tanggal</th>
					<th>Transaksi</th>
					<th><center>Total</center></th>
					<th><center>Sisa</center></th>
					<th>Jatuh Tempo</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($items->transaction as $item)
				@if($item->status == -1 || $item->status == 0)
				<tr>
					<td>{{ date('d-m-Y', strtotime($item->transaction_date))}}</td>
					<td><a href="#" role="button" data-toggle="modal" data-target="#modalDetil{{$item->id}}" >{{$item->transaction_code}}</a></td>
					<td align="right">
						Rp {{ number_format(abs($item->pivot->amount), 2, ",", ".")}}
					</td>
					<td align="right">
						<?php $bayar=0; ?>
						@foreach($item->min as $min)
							@foreach($min->account as $account)
							<?php $bayar+=$account->pivot->amount ?>
							@endforeach
						@endforeach
						<?php
							$multiplier = 1;
							if ($items->accountGroup->normal_balance == "Kredit") {
								$multiplier = -1;
							}
							$sisa = ($bayar+$item->pivot->amount)*$multiplier;
						?>
						@if($sisa <= 0)
						(Rp {{ number_format($sisa*-1, 2, ",", ".")}})
						@else
						Rp {{ number_format($sisa, 2, ",", ".")}}
						@endif
					</td>
					<td>
						{{ date('d-m-Y', strtotime("+".$items->partner->payment_deadline." days", strtotime($item->transaction_date))) }}
					</td>
					<td>

						<a href="#" role="button" data-toggle="modal" data-target="#modal{{$item->id}}" class="btn btn-xs btn-primary"><i class="icon fa fa-money"></i> Riwayat</a>
						@if($item->status==-1)
						<a href="{{url('pay',$item->id)}}" role="button" class="btn btn-xs btn-success"><i class="icon fa fa-money"></i> Bayar</a>
						@endif
					</td>
				</tr>
				<!-- Begin Modal  -->
				<div class="modal fade" id="modal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Riwayat Pembayaran</h4>
							</div>
							<div class="modal-body">
							<div class="row">
								<div class="col-md-2"><label>Tanggal</label></div>
								<div class="col-md-4"><label>Transaksi</label></div>
								<div class="col-md-4"><label>Jumlah</label></div>
								<div class="col-md-2"><label for="">#</label></div>
							</div>
								@foreach($item->min as $min)
							<div class="row">
								<div class="col-md-2">{{$min->transaction_date}}</div>
								<div class="col-md-4">{{$min->name}}</div>
								<div class="col-md-4">@foreach($min->account as $account)
											Rp {{ number_format(abs($account->pivot->amount), 2, ",", ".")}}
											@endforeach
								</div>
								<div class="col-md-2">
									<a href="#modalDelete{{$min->id}}" role="button" class="btn btn-xs btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#modalDelete{{$min->id}}"><i class="icon fa fa-edit"></i> Delete</a>
								</div>
							</div>

								@endforeach

							</div>
						</div>
					</div>
				</div>
				<!-- End Modal  -->

				@foreach($item->min as $min)
				<!-- Begin Modal Delete -->
				<div class="modal fade" id="modalDelete{{$min->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Perhatian!!</h4>
							</div>
							<div class="modal-body">
								<center>Anda yakin akan menghapus transaksi ini ?</center>
							</div>
							<div class="modal-footer">
							<form action="{{url('hapus-bayar',$min->id)}}" method="post">
							<input type="hidden" name="_method" value="delete">
							{!! csrf_field() !!}
								<button type="submit" class="btn btn-danger">Ya</button>
							</form>
								<button type="button" class="btn btn-default " data-dismiss="modal" data-toggle="modal" data-target="#modal{{$item->id}}">Tidak</button>
							</div>
						</div>
					</div>
				</div>
				@endforeach

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
				<!-- End Modal  -->
				@endif
				@endforeach
			</tbody>
			</table>




	</div>
</div>

@endsection
