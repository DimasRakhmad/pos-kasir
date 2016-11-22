@extends('app')

@section('htmlheader_title')
Absen
@endsection

@section('contentheader_title')
Absen Karyawan
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
		<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<form action="{{url('absenKaryawanPost',$id)}}" method="POST" role="form">
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-calendar"></i>
								</div>
								{!!csrf_field()!!}
								<select name="bulan" class="form-control">
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
						</div><center><button type="submit" class="btn btn-primary">Filter</button> </center>
						
					</form>
				</div>
			</div>
		<?php 	
			$tidak = 0;
	        $lembur = 0;
	        $hadir = 0;
		?>
		@foreach($data as $item)
		@if($item->status=="Hadir")
				<?php $hadir++ ?>
				@elseif($item->status=="Lembur")
				<?php $lembur++ ?>
				@elseif($item->status=="Tidak")
				<?php $tidak++ ?>
				@endif
				@endforeach
		<label > Nama : {{$karyawan->nama}}</label>
		<div class="row">
			<div class="col-md-12"><label>Hadir : </label>{{$hadir}} 
			| <label>Absen : </label>{{$tidak}} | <label> Lembur : </label>{{$lembur}}</div>
		</div>
		@if($date==date('Y-m'))
				<label>Absen yang ditampilkan per tangal <?php echo date('d-m-Y') ?></label>
			@endif
		<table class="table">
			<tr>
				<th width="30%">Tanggal</th>
				<th>Status</th>	
			</tr>
			@foreach($data as $item)

			<tr>
				<td>{{ date('d-m-Y', strtotime($item->tanggal))}}</td>
				<td>{{$item->status}}</td>
				</tr>
			@endforeach
		</table>
	</div>
</div>


@endsection
