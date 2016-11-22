@extends('app')

@section('htmlheader_title')
Hutang
@endsection

@section('contentheader_title')
@if($akun->group_id==8)
Hutang
@elseif($akun->group_id==7)
Piutang
@endif
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
	@if($akun->group_id==7)
		<h3 class="box-title">Daftar Piutang</h3>
	@elseif($akun->group_id==8)
	<h3 class="box-title">Daftar Hutang</h3>
	@endif
		
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
					<th>Hutang</th>
					<th><center>Sisa</center></th>
					<th></th>

				</tr>
			</thead>
			<tbody>
			<?php $i=0 ?>
			@if($akun->group_id==7)
				@foreach($akun->transaction as $trans)
					@if($trans->status ==  -1)
					
					<tr>
						<?php $i++ ?>
						<td >{{ $i }}</td>
						<td >{{$trans->name}}</td>
						@if(count($trans->min)==0)
						<td align="right" >Rp {{ number_format(abs($trans->pivot->amount), 2, ",", ".")}}</td>
						@else
						<td align="right" >Rp {{ number_format(abs($trans->min[0]->account[0]->pivot->amount+$trans->pivot->amount), 2, ",", ".")}}</td>
						@endif
						<td>

							<a href="{{url('pay',$trans->id)}}" role="button" class="btn btn-xs btn-success"><i class="icon fa fa-money"></i> Bayar</a>
						</td>
						
					</tr>
					@endif
					<!-- Begin Modal Delete -->
					
					<!-- End Modal Delete -->
				@endforeach
			@elseif($akun->group_id==8)
				@foreach($akun->transaction as $trans)
				@if($trans->status == -1)
				
				<tr>
					<?php $i++ ?>
					<td >{{ $i }}</td>
					<td >{{$trans->name}}</td>
					@if(count($trans->min)==0)
					<td align="right" >Rp {{ number_format($trans->pivot->amount, 2, ",", ".")}}</td>
					@else
					<td align="right" >Rp {{ number_format($trans->min[0]->account[0]->pivot->amount+$trans->pivot->amount, 2, ",", ".")}}</td>
					
					@endif
					<td>

						<a href="{{url('payPiutang',$trans->id)}}" role="button" class="btn btn-xs btn-success"><i class="icon fa fa-money"></i> Bayar</a>
					</td>
					
				</tr>
				@endif
				@endforeach
			@endif
			</tbody>
		</table>
	</div>
</div>


@endsection
