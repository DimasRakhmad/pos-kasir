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
<link rel="stylesheet" href="{{asset('/plugins/datepicker/datepicker3.css')}}" />
@endsection

@section('additional_scripts')
<!-- DATA TABES SCRIPT -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/plugins/datepicker/bootstrap-datepicker.js')}}"></script>

<!-- page script -->
<script type="text/javascript">
	function checkDate(datecheck)
	{
		$('#datecheck').html("<img src='{{asset('img/loading.gif')}}'' />");
		$.get("{{url('cekTanggalAbsen')}}" + "/" + datecheck , function(data)
			{
				   if (data.warning != '' || data.warning != undefined || data.warning != null)
				   {
					  $('#datecheck').html(data.warning);
				   }

				   if (data.status == true){
				   		$('#tambah').prop("disabled",true);
				   }else{
				   		$('#tambah').prop("disabled",false);
				   }
	          });
	}
	// Cek semua hadir
	function checkedAllMingguan(cekcek) {
	    var aa =  document.getElementsByClassName("hadirMingguan");
	    for (var i =0; i < aa.length; i++) 
	    {
	        aa[i].checked = cekcek.checked ;
	    }
 	}

 	function checkedAllBulanan(cekcek) {
	    var aa =  document.getElementsByClassName("hadirBulanan");
	    for (var i =0; i < aa.length; i++) 
	    {
	        aa[i].checked = cekcek.checked ;
	    }
 	}
	$(function() {
	    $("#datepicker").datepicker({ startDate: "-2m",endDate: "today"});
	});
	$(function () {
		$('#item_table').DataTable();
	});
	@foreach($mingguan as $item)
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
    @foreach($bulanan as $item)
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
		<h3 class="box-title">Daftar Karyawan</h3>
		
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
		<form action="{{url('absensi')}}" method="POST" role="form">
		<div class="row">
				<div class="col-md-4 col-md-offset-4">
					
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-calendar"></i>
								</div>
								<input type="text" name="tanggal" class="form-control" id="datepicker" data-date-format="yyyy-mm-dd" onblur="checkDate(this.value)">
							</div><span id="datecheck" style="padding-left:10px; ; vertical-align: middle;"></span>
						
					
				</div>
			</div>
			</div>
		 <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Bulanan</a></li>
              <li><a href="#tab_2" data-toggle="tab">Mingguan</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
              <div class="checkbox">
                  <label>
                    <input type='checkbox' onclick='checkedAllBulanan(this)'> Hadir Semua
                  </label>
                </div>
                <table class="table table-hover table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Hadir</th>
							<th>Setengah Hari</th>
							<th>Tidak</th>
							<th>Lembur</th>
							<th></th>
							

						</tr>
					</thead>
					<tbody>
					
					{!!csrf_field()!!}
					<?php $i=0; ?>
						@foreach ($bulanan as $item)
						<?php $i++; ?>
						<tr>
							<td>{{$i}}</td>
							<td>{{ $item->nama }} <input type="hidden" name="bulanan[{{$i}}][karyawan_id]" value="{{$item->id}}"></td>
							<td><input class="hadirBulanan" type="radio" name="bulanan[{{$i}}][status]" id="hadir{{$item->id}}" value="Hadir" required></td>
							<td><input type="radio" name="mingguan[{{$i}}][status]" id="tidak{{$item->id}}" value="Setengah Hari" required></td>
							<td><input type="radio" name="bulanan[{{$i}}][status]" id="tidak{{$item->id}}" value="Tidak" required></td>
							<td><input type="radio" name="bulanan[{{$i}}][status]" id="lembur{{$item->id}}" value="Lembur" required></td>
							<td>
								<select style="display:none;" name="bulanan[{{$i}}][notes]" id="opsi{{$item->id}}" class="form-control">
									<option value="1">18.00</option>
									<option value="2">19.00</option>
									<option value="3">20.00</option>
									<option value="4">21.00</option>
									<option value="5">22.00</option>
									<option value="6">23.00</option>
									<option value="7">24.00</option>
								</select>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
               <div class="checkbox">
                  <label>
                    <input type='checkbox' onclick='checkedAllMingguan(this)'> Hadir Semua
                  </label>
                </div>
                <table class="table table-hover table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Hadir</th>
							<th>Setengah Hari</th>
							<th>Tidak</th>
							<th>Lembur</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php $i=0; ?>
						@foreach ($mingguan as $item)
						<?php $i++; ?>
						<tr>
							<td>{{$i}}</td>
							<td>{{ $item->nama }} <input type="hidden" name="mingguan[{{$i}}][karyawan_id]" value="{{$item->id}}"></td>
							<td><input class="hadirMingguan" type="radio" name="mingguan[{{$i}}][status]" id="hadir{{$item->id}}" value="Hadir" required></td>
							<td><input type="radio" name="mingguan[{{$i}}][status]" id="tidak{{$item->id}}" value="Setengah Hari" required></td>
							<td><input type="radio" name="mingguan[{{$i}}][status]" id="tidak{{$item->id}}" value="Tidak" required></td>
							<td><input type="radio" name="mingguan[{{$i}}][status]" id="lembur{{$item->id}}" value="Lembur" required></td>
							<td>
								<select style="display:none;" name="mingguan[{{$i}}][notes]" id="opsi{{$item->id}}" class="form-control">
									<option value="1">18.00</option>
									<option value="2">19.00</option>
									<option value="3">20.00</option>
									<option value="4">21.00</option>
									<option value="5">22.00</option>
									<option value="6">23.00</option>
									<option value="7">24.00</option>
								</select>
							</td>
						</tr>
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
		
		<button id="tambah" type="submit" class="btn btn-primary">Tambah Data</button> 
		</form>
	</div>
</div>


@endsection
