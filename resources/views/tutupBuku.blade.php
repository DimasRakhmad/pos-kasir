@extends('app')

@section('htmlheader_title')
Tutup Buku
@endsection

@section('contentheader_title')
Tutup Buku
@endsection

@section('additional_styles')
<!-- DATA TABLES -->
<link rel="stylesheet" href="{{asset('/plugins/datepicker/datepicker3.css')}}" />
@endsection

@section('additional_scripts')
<script src="{{asset('/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script>
	$(function() {
	    $("#datepicker").datepicker();
	    $("#datepicker2").datepicker();
	});
</script>
@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Ganti Password</h3>
		
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
		<p class="text-red"> <b>Keterangan: (*) Wajib diisi</b></p>
		<form role="form" method="POST" action="{{url('tutupBuku')}}">
		{!! csrf_field() !!}
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<center><label>Pilih Tanggal<a class="text-red">*</a></label></center>
				</div>
				
			</div>
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<input type="hidden" name="dari" value="{{$dari}}">
					<input class="form-control" type="text" name="sampai" id="datepicker" style="text-align:center" required/>
				</div>
				
			</div>
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
				<br>
					<center><button type="submit" class="btn btn-primary">Tutup Buku</button></center>
				</div>
			</div>
			
			
		</form>
		
	</div>
</div>


@endsection
