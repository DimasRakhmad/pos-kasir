@extends('app')

@section('htmlheader_title')
Absen
@endsection

@section('contentheader_title')
Absen Karyawan Mingguan
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
	var id;
	var original_link = "/sum-absen-mingguan";
	$('#pilih').on('change', function(){
	    $('#filter').attr('href', original_link);
	    id = $(this).val();
	    var new_href = $('#filter').attr('href') + '/' + id;
	    $('#filter').attr('href', new_href);
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
					
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-calendar"></i>
								</div>
								
								<select name="date" class="form-control" id="pilih">
									<option value="">Pilih Minggu</option>
									@foreach($listMinggu as $item)
									<option value="{{$item['value']}}">{{$item['name']}}</option>
									@endforeach
								</select>
							</div>
						</div><center><a class="btn btn-primary" href="" id="filter">Filter</a> </center>
						
					
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
						$tidak = 0;
			            $lembur = 0;
			            $kasbon = 0;
			            $hadir = 0;
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
