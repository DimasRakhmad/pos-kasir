<?php use Carbon\Carbon; ?>
@extends('app')

@section('htmlheader_title')
Daftar Absen
@endsection

@section('contentheader_title')
Daftar Absen
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
		<h3 class="box-title">Daftar Absen </h3>


		<div class="box-tools pull-right">
		@if(count($cekAbsen)==0)
			<a href="{{ url('absensi') }}" role="button" class="btn btn-xs btn-primary"><i class="fa fa-plus"> Absen Hari ini</i></a>
			@endif
			<a href="{{ url('absenPilih') }}" role="button" class="btn btn-xs btn-primary"><i class="fa fa-plus"> Tambah Absen</i></a>
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
                <table  class="table table-hover table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Inputer</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
			<?php $i=0; $date=date("Y-m"); ?>
				@foreach ($bulanan as $item)
				<?php $i++; ?>
				<tr>
					<td>{{$i}}</td>
					<td>{{ date('d-m-Y', strtotime($item->tanggal)) }}</td>
					<td>{{ $item->user->name }}</td>
					<td>
						<a href="{{url('absenShow',$item->id)}}" role="button" class="btn btn-xs btn-primary"><i class="icon fa fa-folder-open-o"></i> Detil</a>
						@if($item->status == 0)
						<a href="{{url('absenEdit',$item->id)}}" role="button" class="btn btn-xs btn-success"><i class="icon fa fa-edit"></i> Edit</a>
						@endif
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
								<center>Anda yakin akan menghapus data {{$item->name}} ?</center>
							</div>
							<div class="modal-footer">
							<form action="{{route('karyawan.destroy',$item->id)}}" method="post">
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
			</tbody>
		</table>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <table  class="table table-hover table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Inputer</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
			<?php $i=0; $dateAfter = Carbon::now()->endOfWeek()->toDateString(); $dateBefore = Carbon::now()->startOfWeek()->toDateString(); ?>
				@foreach ($mingguan as $item)
				<?php $i++; ?>
				<tr>
					<td>{{$i}}</td>
					<td>{{ date('d-m-Y', strtotime($item->tanggal)) }}</td>
					<td>{{ $item->user->name }}</td>
					<td>
						<a href="{{url('absenShow',$item->id)}}" role="button" class="btn btn-xs btn-primary"><i class="icon fa fa-folder-open-o"></i> Detil</a>
						@if($item->status == 0)
						<a href="{{url('absenEdit',$item->id)}}" role="button" class="btn btn-xs btn-success"><i class="icon fa fa-edit"></i> Edit</a>
						@endif
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
								<center>Anda yakin akan menghapus data {{$item->name}} ?</center>
							</div>
							<div class="modal-footer">
							<form action="{{route('karyawan.destroy',$item->id)}}" method="post">
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
