@extends('app')

@section('htmlheader_title')
Karyawan
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
	@foreach($items->absen as $item)
	$('#setengah{{$item->id}}').on('change', function() {
      if ($(this).is(":checked"))
      {
        $("#opsi{{$item->id}}").hide();
        document.getElementById("opsi{{$item->id}}").required = false;
      }
      else
      {
      	$("#opsi{{$item->id}}").show();
        document.getElementById("opsi{{$item->id}}").required = true;
      }
    });
	$('#lembur{{$item->id}}').on('change', function() {
      if ($(this).is(":checked"))
      {
        $("#opsi{{$item->id}}").show();
        document.getElementById("opsi{{$item->id}}").required = true;
      }
      else
      {
        $("#opsi{{$item->id}}").hide();
        document.getElementById("opsi{{$item->id}}").required = false;
      }
    });
    $('#hadir{{$item->id}}').on('change', function() {
      if ($(this).is(":checked"))
      {
        $("#opsi{{$item->id}}").hide();
        document.getElementById("opsi{{$item->id}}").required = false;
      }
      else
      {
        $("#opsi{{$item->id}}").show();
        document.getElementById("opsi{{$item->id}}").required = true;
      }
    });
    $('#tidak{{$item->id}}').on('change', function() {
      if ($(this).is(":checked"))
      {
        $("#opsi{{$item->id}}").hide();
        document.getElementById("opsi{{$item->id}}").required = false;
      }
      else
      {
        $("#opsi{{$item->id}}").show();
        document.getElementById("opsi{{$item->id}}").required = true;
      }
    });
    @endforeach
    
</script>
</script>
@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Tanggal {{$items->tanggal}}</h3>
		
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

		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Hadir</th>
					<th>Setengah Hari</th>
					<th>Tidak</th>
					<th>Lembur</th>
					<th>	</th>
					

				</tr>
			</thead>
			<tbody>
			<form action="{{url('absensi',$items->id)}}" method="POST" role="form">
			<input type="hidden" name="_method" value="put">
			{!!csrf_field()!!}
			<?php $i=0; ?>
				@foreach ($items->absen as $item)
				<?php $i++; ?>
				<tr>
					<td>{{$i}}</td>
					<td>{{ $item->karyawan->nama }} <input type="hidden" name="absen[{{$i}}][absen_id]" value="{{$item->id}}"></td>
					<td>
						@if($item->status == "Hadir")
						<input type="radio" name="absen[{{$i}}][status]" id="hadir{{$item->id}}" value="Hadir" checked required>
						@else
						<input type="radio" name="absen[{{$i}}][status]" id="hadir{{$item->id}}" value="Hadir" required>
						@endif
					</td>
					<td>
						@if($item->status == "Setengah Hari")
						<input type="radio" name="absen[{{$i}}][status]" id="hadir{{$item->id}}" value="Setengah Hari" checked required>
						@else
						<input type="radio" name="absen[{{$i}}][status]" id="hadir{{$item->id}}" value="Setengah Hari" required>
						@endif
					</td>
					<td>
						@if($item->status == "Tidak")
						<input type="radio" name="absen[{{$i}}][status]" id="tidak{{$item->id}}" value="Tidak" checked required>
						@else
						<input type="radio" name="absen[{{$i}}][status]" id="tidak{{$item->id}}" value="Tidak" required>
						@endif
					</td>
					<td>
						@if($item->status == "Lembur")
						<input type="radio" name="absen[{{$i}}][status]" id="lembur{{$item->id}}" value="Lembur" checked required>
						@else
						<input type="radio" name="absen[{{$i}}][status]" id="lembur{{$item->id}}" value="Lembur" required>
						@endif
					</td>
					<td>
					@if($item->status == "Lembur")
						<?php 
							if($item->notes){
								$note = json_decode($item->notes, true);
							
						 ?>
						<select name="absen[{{$i}}][notes]" id="opsi{{$item->id}}" class="form-control" required>
							@if($note['tipe_lembur']==1)
							<option value="1" selected>18.00</option>
							@else
							<option value="1">18.00</option>
							@endif
							@if($note['tipe_lembur']==2)
							<option value="2" selected>19.00</option>
							@else
							<option value="2">19.00</option>
							@endif
							@if($note['tipe_lembur']==3)
							<option value="3" selected>20.00</option>
							@else
							<option value="3">20.00</option>
							@endif
							@if($note['tipe_lembur']==4)
							<option value="4" selected>21.00</option>
							@else
							<option value="4">21.00</option>
							@endif
							@if($note['tipe_lembur']==5)
							<option value="5" selected>22.00</option>
							@else
							<option value="5">22.00</option>
							@endif
							@if($note['tipe_lembur']==6)
							<option value="6" selected>23.00</option>
							@else
							<option value="6">23.00</option>
							@endif
							@if($note['tipe_lembur']==7)
							<option value="7" selected>24.00</option>
							@else
							<option value="7">24.00</option>
							@endif
						</select>
						<?php }else{ ?>
						<select name="absen[{{$i}}][notes]" id="opsi{{$item->id}}" class="form-control" required>
							<option value="1">18.00</option>
							<option value="2">19.00</option>
							<option value="3">20.00</option>
							<option value="4">21.00</option>
							<option value="5">22.00</option>
							<option value="6">23.00</option>
							<option value="7">24.00</option>
						</select>
						<?php } ?>
					@else
						<select style="display:none;" name="absen[{{$i}}][notes]" id="opsi{{$item->id}}" class="form-control">
							<option value="1">18.00</option>
							<option value="2">19.00</option>
							<option value="3">20.00</option>
							<option value="4">21.00</option>
							<option value="5">22.00</option>
							<option value="6">23.00</option>
							<option value="7">24.00</option>
						</select>
					@endif
					</td>
					
				</tr>

				
				@endforeach

			</tbody>
		</table>
		<button type="submit" class="btn btn-primary">Perbaharui Data</button> 
		</form>
	</div>
</div>


@endsection
