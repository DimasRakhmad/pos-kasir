@extends('app')

@section('htmlheader_title')
Daftar Laporan Penggajian
@endsection

@section('contentheader_title')
Daftar Laporan Penggajian
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
		<h3 class="box-title">Daftar Laporan Penggajian</h3>
		<div class="box-tools pull-right">
			<!-- <a href="{{ url('kegiatan') }}" role="button" class="btn btn-xs btn-primary"><i class="fa fa-plus"> List Absen Karyawan</i></a> -->
			<a href="{{ url('generate-gaji') }}" role="button" class="btn btn-xs btn-primary"><i class="fa fa-book"> Rekap Gaji</i></a>
		</div>
	</div>

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

		
		
		<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Bulanan</a></li>
              <li><a href="#tab_2" data-toggle="tab">Mingguan</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
              <table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php $i=0; ?>
				@foreach ($itemsBulanan as $item)
				<?php $i++; ?>
				<tr>
					<td>{{$i}}</td>
					<td>{{ date('d-m-Y', strtotime($item->tanggal)) }}</td>
					<td>
						<a href="{{url('slipGaji/Bulanan',$item->tanggal)}}" role="button" class="btn btn-xs btn-primary"><i class="icon fa fa-print"></i>Print</a>
						<a href="{{url('gajiShow/Bulanan',$item->tanggal)}}" role="button" class="btn btn-xs btn-primary"><i class="icon fa fa-folder-open-o"></i>Detil</a>
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
								<center>Anda yakin akan menghapus data gaji {{$item->tanggal}} ?</center>
							</div>
							<div class="modal-footer">
							<form action="{{url('hapus-gaji')}}" method="post">
							<input type="hidden" name="jenis" value="Bulanan">
							<input type="hidden" name="tanggal" value="{{$item->tanggal}}">
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
			</tbody>
		</table>

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
              <table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php $i=0; ?>
				@foreach ($itemsMingguan as $item)
				<?php $i++; ?>
				<tr>
					<td>{{$i}}</td>
					<td>{{ date('d-m-Y', strtotime($item->tanggal)) }}</td>
					<td>
						<a href="{{url('slipGaji/Mingguan',$item->tanggal)}}" role="button" class="btn btn-xs btn-primary"><i class="icon fa fa-print"></i>Print</a>
						<a href="{{url('gajiShow/Mingguan',$item->tanggal)}}" role="button" class="btn btn-xs btn-primary"><i class="icon fa fa-folder-open-o"></i>Detil</a>
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
								<center>Anda yakin akan menghapus data gaji {{$item->tanggal}} ?</center>
							</div>
							<div class="modal-footer">
							<form action="{{url('hapus-gaji')}}" method="post">
							<input type="hidden" name="jenis" value="Mingguan">
							<input type="hidden" name="tanggal" value="{{$item->tanggal}}">
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
