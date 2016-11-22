@extends('app')

@section('htmlheader_title')
@if($akun->group_id==7)
Hutang
@elseif($akun->group_id==8)
Piutang
@endif
@endsection

@section('contentheader_title')
{{$akun->name}}
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

		@if($jurnal == NULL)
		<div class="alert alert-warning alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<i class="icon fa fa-warning"></i>
			Opps! Maaf, tidak ada data.
		</div>
		@else
		<table  class="table table-hover">
			<thead>
				<tr>
					<th width="20%">Tanggal</th>
					<th width="30%">Deskripsi</th>
					<th width="20%"><center>Jumlah</center></th>
					<th width="20%"><center>Jatuh Tempo</center></th>
					<th width="10%"></th>
				</tr>
			</thead>
			<tbody>
				<?php $saldo=0; ?>
				@foreach($jurnal as $j)
				<tr>
				<?php $saldo += $j->amount ?>
					<td>{{ date('d-m-Y', strtotime($j->transaction_date)) }}</td>
					<td><b>{{ $j->transName }}</b> </td>
					<td align="right">
						@if($j->amount<=0)
						(Rp {{ number_format($j->amount*-1, 2, ",", ".")}})
						@else
						Rp {{ number_format($j->amount, 2, ",", ".")}}
						@endif

					</td>
					<td align="right">
						@if(substr($j->transName,0,17)=="Pembayaran Hutang" && substr($j->transName,0,18)=="Pembayaran Piutang")
						{{date("d-m-Y",strtotime(date("Y-m-d", strtotime($j->transaction_date)) . " + ".$j->dead."day"))}}
						@endif
					</td>
					<td>
						@if(substr($j->transName,0,17)!="Pembayaran Hutang" && substr($j->transName,0,18)!="Pembayaran Piutang")
						<a href="{{url('detailHutang',$j->id)}}" role="button" class="btn btn-xs btn-primary"><i class="icon fa fa-folder-open-o"></i>Detil</a>
						@endif
					</td>
				</tr>
				@endforeach
				<?php
					if ($jurnalName->accountGroup->normal_balance == 'Kredit') $saldo = $saldo*-1;
				?>
				<tr>
					<td  ><b>Total Saldo :</b></td>
					<td colspan="4" align="left"><b>Rp {{ number_format($saldo, 2, ",", ".")}}</b></td>
				</tr>


			</tbody>
			</table>



			@endif
	</div>
</div>

@endsection
