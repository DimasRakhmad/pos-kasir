@extends('app')

@section('htmlheader_title')
Biaya
@endsection

@section('contentheader_title')
Daftar Biaya
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
		<h3 class="box-title">Daftar Biaya</h3>
		<div class="box-tools pull-right">
			<a href="{{ url('bayar') }}" role="button" class="btn btn-xs btn-primary"><i class="fa fa-plus"> Bayar Biaya</i></a>
			<a href="{{ url('createBiaya') }}" role="button" class="btn btn-xs btn-primary"><i class="fa fa-plus"> Tambah Biaya</i></a>
		</div>
	</div>

	<div class="box-body">
	<a href="{{ url('excelIndexBiaya') }}" role="button" class="btn btn-xs btn-primary"><i class="fa fa-cloud-download"> xls</i></a>
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
					
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-calendar"></i>
								</div>
								
								<select name="bulan" class="form-control" id="bulan">
									<option value="">Pilih Bulan</option>
									@foreach($tigaBulan as $bulan)
										@if($bulan['m']==$date)
										<option value="{{$bulan['id']}}" selected>{{$bulan['name']}}</option>
										@else
										<option value="{{$bulan['id']}}">{{$bulan['name']}}</option>
										@endif
									
									@endforeach
								</select>
							</div>
						</div><center><a class="btn btn-primary" href="" id="filter">Filter</a> </center>
						
					
				</div>
			</div>
			@if($date==date('Y-m'))
				<label>Data per tangal <?php echo date('d-m-Y') ?></label>
			@endif
		
		<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Operasional</a></li>
              <li><a href="#tab_2" data-toggle="tab">Non Operasional</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <table class="table table-hover table-striped">
					<thead>
						<tr>
							<th>No.</th>
							<th>Nama</th>
							<th>Deksripsi</th>
							<th><center>Saldo</center></th>
							<th></th>

						</tr>
					</thead>
					<tbody>
					<?php $i=0 ; $total=0; ?>
						@foreach ($items as $account)
						@if($account->group_id == 3)
						<?php $i++ ?>
						<tr>
							<td width="7%" align="right">{{ $i }}</td>
							<td>{{ $account->name }}</td>
							<td >{{ $account->notes }}</td>
							<td align="right" >
								<?php $saldo = 0; ?>
								@foreach ($account->transaction as $trans)
								<?php $saldo += $trans->pivot->amount; ?>
								@endforeach
								<?php if ($account->accountGroup->normal_balance == 'Kredit') $saldo = $saldo*-1 ?>
								@if ($saldo < 0)
								(Rp {{ number_format($saldo*-1, 2, ",", ".")}})
								@else
								Rp {{ number_format($saldo, 2, ",", ".")}}
								@endif
								<?php $total+=$saldo ?>
							</td>
							<td >
								<a href="{{url('detailBiaya/'.$date,$account->id)}}" role="button" class="btn btn-xs btn-primary"><i class="icon fa fa-folder-open-o"></i>Detil</a>
								@if($account->id != 4 && $account->id != 5 && $account->id != 6 && $account->id != 9)
								<a href="{{url('biaya-edit',$account->id)}}" role="button" class="btn btn-xs btn-success"><i class="icon fa fa-edit"></i> Edit</a>

						<a href="#" role="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modalDelete{{$account->id}}"><i class="icon fa fa-edit"></i> Delete</a>
						@endif
							</td>
							
						</tr>
						<!-- Begin Modal Delete -->
				<div class="modal fade" id="modalDelete{{$account->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Perhatian!!</h4>
							</div>
							<div class="modal-body">
								<center>Anda yakin akan menghapus biaya {{$account->name}} ?</center>
							</div>
							<div class="modal-footer">
							<form action="{{route('account.destroy',$account->id)}}" method="post">
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
						<tr>
							<td colspan="2"></td>
							<td colspan="2" align="right"><label > Total </label> : {{ number_format($total, 2, ",", ".")}}</td>
							<td></td>

						</tr>
					</tbody>
				</table>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <table class="table table-hover table-striped">
					<thead>
						<tr>
							<th>No.</th>
							<th>Nama</th>
							<th>Deksripsi</th>
							<th><center>Saldo</center></th>
							<th></th>

						</tr>
					</thead>
					<tbody>
					<?php $i=0 ; $total=0; ?>
						@foreach ($items as $account)
						@if($account->group_id == 4)
						<?php $i++ ?>
						<tr>
							<td width="7%" align="right">{{ $i }}</td>
							<td>{{ $account->name }}</td>
							<td >{{ $account->notes }}</td>
							<td align="right" >
								<?php $saldo = 0; ?>
								@foreach ($account->transaction as $trans)
								<?php $saldo += $trans->pivot->amount; ?>
								@endforeach
								<?php if ($account->accountGroup->normal_balance == 'Kredit') $saldo = $saldo*-1 ?>
								@if ($saldo < 0)
								(Rp {{ number_format($saldo*-1, 2, ",", ".")}})
								@else
								Rp {{ number_format($saldo, 2, ",", ".")}}
								@endif
								<?php $total+=$saldo ?>
							</td>
							<td >
								<a href="{{url('detailBiaya/'.$date,$account->id)}}" role="button" class="btn btn-xs btn-primary"><i class="icon fa fa-folder-open-o"></i>Detil</a>
								<a href="{{url('biaya-edit',$account->id)}}" role="button" class="btn btn-xs btn-success"><i class="icon fa fa-edit"></i> Edit</a>
								<a href="#" role="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modalDelete{{$account->id}}"><i class="icon fa fa-edit"></i> Delete</a>
									</td>
							</td>
							
						</tr>
						<!-- Begin Modal Delete -->
				<div class="modal fade" id="modalDelete{{$account->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Perhatian!!</h4>
							</div>
							<div class="modal-body">
								<center>Anda yakin akan menghapus biaya {{$account->name}} ?</center>
							</div>
							<div class="modal-footer">
							<form action="{{route('account.destroy',$account->id)}}" method="post">
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
						<tr>
							<td colspan="2"></td>
							<td colspan="2" align="right"><label > Total </label> : {{ number_format($total, 2, ",", ".")}}</td>
							<td></td>

						</tr>
					</tbody>
				</table>
              </div>
              <!-- /.tab-pane -->
              
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
	</div>
</div>


@endsection
