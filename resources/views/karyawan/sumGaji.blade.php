@extends('app')

@section('htmlheader_title')
Absen
@endsection

@section('contentheader_title')
Absen Karyawan Bulanan
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
					<form action="{{url('sumAbsen')}}" method="POST" role="form">
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
			@if($date==date('Y-m'))
				<label>Absen yang ditampilkan per tangal <?php echo date('d-m-Y') ?></label>
			@endif
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th width="10%">No</th>
					<th>Nama</th>
					<th width="10%">Hadir</th>
					<th width="10%">Setengah Hari</th>
					<th width="10%">Absen</th>
					<th width="10%">Lembur</th>

				</tr>
			</thead>
			<tbody>
			<?php $i=0; ?>
				@foreach ($items as $item)
				<?php 
						$i++; 
						$tidak    = 0;
						$lembur   = 0;
						$kasbon   = 0;
						$hadir    = 0;
						$setengah = 0;
				?>
				@foreach($item->absen as $absen)
					@if($absen->status == "Tidak")
	                    <?php $tidak++; ?>
	                @elseif ($absen->status == "Lembur")
	                    <?php $lembur++; ?>
	                @elseif ($absen->status == "Hadir") 
	                    <?php $hadir++; ?>
	                @elseif ($absen->status == "Setengah Hari") 
	                    <?php $setengah++; ?>
	                @endif
				@endforeach
				<tr>
					<td>{{$i}}</td>
					<td>{{ $item->nama }}</td>
					<td>{{$hadir}}</td>
					<td>{{$setengah}}</td>
					<td>{{$tidak}}</td>
					<td>{{$lembur}}</td>
				</tr>

				
				@endforeach

			</tbody>
		</table>
	</div>
</div>


@endsection
