@extends('app')

@section('htmlheader_title')
Piutang
@endsection

@section('contentheader_title')
Piutang
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

	// Cari berdasarkan kode
	var code;
	var original_link = "/cari-hutang-kode";
	$('#codeInput').on('keyup', function(){
	    $('#kodeCari').attr('href', original_link);
	    code = $(this).val();
	    var new_href = $('#kodeCari').attr('href') + '/' + code;
	    $('#kodeCari').attr('href', new_href);
	});
</script>
@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Daftar Piutang</h3>

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

		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="input-group input-group-sm">
						<input type="text" name="code" id="codeInput" placeholder="Cari berdasarkan No Resi" class="form-control">
						<span class="input-group-btn">
							<a id="kodeCari" role="button" href="" class="btn btn-primary btn-block">Filter</a>
						</span>
				</div>
			</div>
		</div>

		<table id="item_table" class="table table-hover table-striped">
			<thead>
				<tr>
					<th>No.</th>
					<th>Piutang</th>
					<th><center>Jumlah</center></th>
					<th></th>

				</tr>
			</thead>
			<tbody>
			<?php $i=0 ?>
				@foreach ($items as $item)
				<?php $i++ ?>
				<tr>
					<td >{{ $i }}</td>
					<td >@if($item->partner)
						{{ $item->partner->company }} (CP : {{ $item->partner->name }} )
						@else
						{{$item->name}}
						@endif</td>
					<td align="right" >
						<?php $saldo = 0; ?>
						@foreach ($item->transaction as $trans)
						<?php $saldo += $trans->pivot->amount; ?>
						@endforeach
						<?php if ($item->accountGroup->normal_balance == 'Kredit') $saldo = $saldo*-1 ?>

						@if($saldo <= 0)
						(Rp {{ number_format($saldo*-1, 2, ",", ".")}})
						@else
						Rp {{ number_format($saldo, 2, ",", ".")}}
						@endif

					</td>
					<td >
						@if($item->id == 7)
						<a href="{{url('daftarPiutangKaryawan')}}" role="button" class="btn btn-xs btn-primary"><i class="icon fa fa-folder-open-o"></i>Detil</a>
						@else
						<a href="{{url('show',$item->id)}}" role="button" class="btn btn-xs btn-primary"><i class="icon fa fa-folder-open-o"></i> Detil</a>
						@endif

					</td>

				</tr>

				<!-- Begin Modal Delete -->

				<!-- End Modal Delete -->
				@endforeach
			</tbody>
		</table>
	</div>
</div>


@endsection
