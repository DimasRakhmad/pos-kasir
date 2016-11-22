@extends('app')

@section('htmlheader_title')
Piutang
@endsection

@section('contentheader_title')

Piutang Karyawan
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
		
		<table  class="table table-hover">
			<thead>
				<tr>
					<th width="5%">No</th>
					<th >Nama</th>
					<th >Jumlah Kasbon</th>
					<th ></th>
				</tr>
			</thead>
			<tbody>
			<?php $i=0 ?>
				@foreach($items as $item)
				<?php $i++ ?>
				<tr>
					<td>{{$i}}</td>
					<td>{{$item->karyawan->nama}}</td>
					<td>
						<?php $total = 0 ?>
						@foreach($item->account as $account)
						@if($account->id == 7)
						<?php $total+=$account->pivot->amount ?>
						@endif
						@endforeach
						Rp {{ number_format($total, 2, ",", ".")}}
					</td>
					<td></td>
				</tr>
				@endforeach		
			</tbody>
			</table>
	</div>
</div>

@endsection
