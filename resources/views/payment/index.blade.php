@extends('app')

@section('htmlheader_title')
Kas
@endsection

@section('contentheader_title')
Kas
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
		<h3 class="box-title">Daftar Kas</h3>
		<div class="box-tools pull-right">
			<a href="{{ url('penyesuaian-dana') }}" role="button" class="btn btn-xs btn-primary"><i class="fa fa-arrows-v"> Penyesuaian Dana</i></a>
			<a href="{{ url('transferDana') }}" role="button" class="btn btn-xs btn-primary"><i class="fa fa-arrows-h"> Pindah Dana</i></a>
			<a href="{{ route('bank.create') }}" role="button" class="btn btn-xs btn-primary"><i class="fa fa-plus"> Tambah Bank</i></a>
		</div>
	</div>

	<div class="box-body">
	<a href="{{ url('excelIndexBank') }}" role="button" class="btn btn-xs btn-primary"><i class="fa fa-cloud-download"> xls</i></a>
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
					<th>Nama</th>
					<th>Saldo</th>
					<th></th>

				</tr>
			</thead>
			<tbody><?php $i = 0; ?>
			@foreach ($items as $item)
			<?php $i++ ?>
				<tr>
					<td width="7%" align="right">{{ $i }}</td>
					<td width="30%">
						@if($item->group_id==10)
						Bank
						@endif
						{{ $item->name }}
					</td>
					<td align="right" width="25%">
						<?php $saldo = 0; ?>
						@foreach ($item->transaction as $trans)
						<?php $saldo += $trans->pivot->amount; ?>
						@endforeach
						<?php if ($item->accountGroup->normal_balance == 'Kredit') $saldo = $saldo*-1 ?>
						@if ($saldo < 0)
						(Rp {{ number_format($saldo*-1, 2, ",", ".")}})
						@else
						Rp {{ number_format($saldo, 2, ",", ".")}}
						@endif
					</td>
					<td width="18%">
						@if($item->id==1)
						<a href="{{url('indexKas')}}" role="button" class="btn btn-xs btn-primary"><i class="icon fa fa-folder-open-o"></i>Detil</a>
						@endif
						@if($item->id==3)
						<a href="{{url('indexKasTangki')}}" role="button" class="btn btn-xs btn-primary"><i class="icon fa fa-folder-open-o"></i>Detil</a>
						@endif
						@if($item->group_id==10)
						<a href="{{route('bank.show',$item->bank->id)}}" role="button" class="btn btn-xs btn-primary"><i class="icon fa fa-folder-open-o"></i>Detil</a>
						<a href="{{route('bank.edit',$item->bank->id)}}" role="button" class="btn btn-xs btn-success"><i class="icon fa fa-edit"></i> Edit</a>
							@if($item->id!=10)
							<a href="#" role="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modalDelete{{$item->id}}"><i class="icon fa fa-edit"></i> Delete</a>
							@endif
						@endif
					</td>

				</tr>


				@if($item->group_id==10)
				<!-- Begin Modal Delete -->
				<div class="modal fade" id="modalDelete{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Perhatian!!</h4>
							</div>
							<div class="modal-body">
								<center>Anda yakin akan menghapus bank {{$item->name}} ?</center>
							</div>
							<div class="modal-footer">
							<form action="{{route('bank.destroy',$item->bank->id)}}" method="post">
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
				@endif
				@endforeach
			</tbody>
		</table>
		{!! $payment->render() !!}

	</div>
</div>


@endsection
