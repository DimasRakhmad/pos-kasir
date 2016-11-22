@extends('app')

@section('htmlheader_title')
Detil Biaya
@endsection

@section('contentheader_title')
Detil Biaya {{$items->name}}
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
		$('#account_table').DataTable();
	});

	var id;
	var original_link = "/biaya";
	$('#bulan').on('change', function(){
	    $('#filter').attr('href', original_link);
	    id = $(this).val();
	    var new_href = $('#filter').attr('href') + '/' + id;
	    $('#filter').attr('href', new_href);
	});
</script>
@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Detil Biaya {{$items->name}}</h3>
		<div class="box-tools pull-right">
			<!-- <a href="{{ url('createBiaya') }}" role="button" class="btn btn-xs btn-primary"><i class="fa fa-plus"> Tambah Biaya</i></a> -->
		</div>
	</div>

	<div class="box-body">
	<a href="{{ url('excelDetilBiaya/'.$date.'/'.$id) }}" role="button" class="btn btn-xs btn-primary"><i class="fa fa-cloud-download"> xls</i></a>
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

		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>No.</th>
					<th>Tanggal</th>
					<th>Deksripsi</th>
					<th><center>Jumlah</center></th>
					<th></th>


				</tr>
			</thead>
			<tbody>
			<?php $i=0 ; $total=0; ?>
				@foreach ($items->transaction as $item)
				<?php $i++ ?>
				<tr>
					<td width="7%" align="right">{{ $i }}</td>
					<td>{{ date('d-m-Y', strtotime($item->transaction_date)) }}</td>
					<td>
						{{ $item->name }}
						@if ($item->pivot->keterangan != null)
						({{ $item->pivot->keterangan }})
						@endif
					</td>
					<td align="right" >

						@if ($item->pivot->amount < 0)
						(Rp {{ number_format($item->pivot->amount*-1, 2, ",", ".")}})
						@else
						Rp {{ number_format($item->pivot->amount, 2, ",", ".")}}
						@endif
						<?php $total+=$item->pivot->amount ?>
					</td>
					<td>
						<a href="{{url('edit-detil-biaya',$item->id)}}" role="button" class="btn btn-xs btn-success"><i class="icon fa fa-edit"></i> Edit</a>
						<a href="#" role="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modalDelete{{$item->id}}"><i class="icon fa fa-edit"></i> Delete</a>
					</td>

				</tr>
				<!-- Begin Modal Delete -->
				<div class="modal fade" id="modalDelete{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Perhatian!!</h4>
							</div>
							<div class="modal-body">
								<center>Anda yakin akan menghapus transaksi {{$item->name}} ?</center>
							</div>
							<div class="modal-footer">
							<form action="{{route('transactions.destroy',$item->id)}}" method="post">
							<input type="hidden" name="_method" value="delete">
							{!! csrf_field() !!}
								<button type="submit" class="btn btn-danger">Ya</button>
							</form>
								<button type="button" class="btn btn-default " data-dismiss="modal">Tidak</button>
							</div>
						</div>
					</div>
				</div>
				<!-- End Modal Delete -->
				@endforeach
				<tr>
					<td colspan="2"></td>
					<td colspan="2" align="right"><label > Total </label> : {{ number_format($total, 2, ",", ".")}}</td>

				</tr>
			</tbody>
		</table>

	</div>
</div>


@endsection
