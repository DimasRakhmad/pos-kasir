@extends('app')

@section('htmlheader_title')
Daftar Transaksi
@endsection

@section('contentheader_title')
Transaksi
@endsection

@section('additional_styles')
<!-- DATA TABLES -->
<link href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
@endsection

@section('additional_scripts')
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

<!-- DATA TABES SCRIPT -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
	$(function () {
		$('#item_table').DataTable();
	});
	$(function() {
	    $('input[name="daterange"]').daterangepicker({
	    	"locale" : {
	    		"format" : 'D MMMM YYYY',
	    		"daysOfWeek": [
					            "Mg",
					            "Sn",
					            "Sl",
					            "Rb",
					            "Km",
					            "Jm",
					            "Sb"
					        ],
				"monthNames": [
					            "Januari",
					            "Februari",
					            "Maret",
					            "April",
					            "Mei",
					            "Juni",
					            "Juli",
					            "Agustus",
					            "September",
					            "Oktober",
					            "November",
					            "Desember"
					        ],
				"firstDay": 1
	    	}
	    },
	    function (start, end, label) {
	    	$('#filterButton').prop("href", "/daftar-transaksi/" + start.format('YYYY-MM-DD') + "/" + end.format('YYYY-MM-DD'));
	    });
	});

	// Pilih pencarian

	$('#tanggalSelect').on('change', function() {
	        if($(this).is(":checked")){
	            	$('#tanggal').show();
	            	$('#kode').hide();
	            }
	    });
	$('#kodeSelect').on('change', function() {
	        if($(this).is(":checked")){
	            	$('#tanggal').hide();
	            	$('#kode').show();
	            }
	    });

	// Cari berdasarkan kode
	var code;
	var original_link = "/transaksi-cari-kode";
	$('#codeInput').on('keyup', function(){
	    $('#kodeCari').attr('href', original_link);
	    code = $(this).val();
	    var new_href = $('#kodeCari').attr('href') + '/' + code;
	    $('#kodeCari').attr('href', new_href);
	});

	// validasi menampilkan form tanggal atau code
	@if($tipe == 'tanggal')
	$('#kode').hide();
	$('#tanggal').show();
	@elseif ($tipe == 'kode')
	$('#kode').show();
	$('#tanggal').hide();
	@endif

</script>
@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Daftar Transaksi</h3>
	
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
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="col-md-6">
					<div class="form-group">
						<div class="radio">
							<label>
								@if($tipe == 'tanggal')
								<input type="radio" name="cari" id="tanggalSelect" value="tanggal" checked>
								@else
								<input type="radio" name="cari" id="tanggalSelect" value="tanggal">
								@endif
								Tanggal
							</label>
						</div>
					</div>
					
				</div>
				<div class="col-md-6">
					<div class="radio">
						<label>
							@if($tipe == 'kode')
							<input type="radio" name="cari" id="kodeSelect" value="code" checked>
							@else
							<input type="radio" name="cari" id="kodeSelect" value="code" >
							@endif
							Kode Transaksi
						</label>
					</div>
				</div>
			</div>
		</div>

		<div class="row" id="tanggal">	
			<div class="col-md-4 col-md-offset-4">
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon"><i class="fa fa-calendar"></i>
						</div>
						@if($tipe=='tanggal')
						<input class="form-control" type="text" name="daterange" value="{{ date('d F Y', strtotime($begin)) }} - {{ date('d F Y', strtotime($end)) }}" style="text-align:center"/>
						@else
						<input class="form-control" type="text" name="daterange" value="" style="text-align:center"/>
						@endif
					</div>
				</div>
				<a id="filterButton" role="button" href="" class="btn btn-primary btn-block">Filter</a>
			</div>
		</div>
		<div class="row" id="kode" style="display:none;">	
			<div class="col-md-4 col-md-offset-4">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon"><i class="fa fa-barcode"></i>
							</div>
							<input class="form-control" type="text" id="codeInput" name="code" value="{{$code}}" style="text-align:center"/>
						</div>
					</div>
					<a id="kodeCari" role="button" href="" class="btn btn-primary btn-block">Filter</a>
			</div>
		</div>

		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Kode Transaksi</th>
					<th>Nama Transaksi</th>
					<th></th>
					

				</tr>
			</thead>
			<tbody>
			<?php $i=0; ?>
				@foreach ($items as $key => $item)
				<?php $i++; ?>
				<tr>
					<td>{{$key+1}}</td>
					<td>{{ $item->transaction_date }}</td>
					<td>{{ $item->transaction_code }}</td>
					<td>{{ $item->name }}</td>
					<td>
						
						<a href="{{route('transactions.edit',$item->id)}}" role="button" class="btn btn-xs btn-success"><i class="icon fa fa-edit"></i> Edit</a>
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
			</tbody>
		</table>
	</div>
</div>


@endsection
