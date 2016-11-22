@extends('app')

@section('htmlheader_title')
Rekap Gaji
@endsection

@section('contentheader_title')
Rekap Gaji
@endsection

@section('additional_styles')
<!-- DATA TABLES -->

@endsection

@section('additional_scripts')
<script>
	$('#mingguCheck').on('change', function() {
	        if($(this).is(":checked")){
	            	$('#minggu').show();
	            	$('#bulan').hide();
	            	document.getElementById("bulan").required = false;
	            	document.getElementById("minggu").required = true;
	            }
	    });
	$('#bulanCheck').on('change', function() {
	        if($(this).is(":checked")){
	            	$('#bulan').show();
	            	$('#minggu').hide();
	            	document.getElementById("bulan").required = true;
	            	document.getElementById("minggu").required = false;
	            }
	    });
</script>
@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Rekap Gaji</h3>
		
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
		<form role="form" method="POST" action="{{url('generate-gaji')}}">
		{!! csrf_field() !!}
			<div class="form-group">
				<label>Tipe <a class="text-red">*</a></label>
				<div class="radio">
                  <label>
                    <input type="radio"  name="tipe" value="Bulanan" id="bulanCheck" checked required> Bulanan
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio"  name="tipe" value="Mingguan" id="mingguCheck" required> Mingguan
                  </label>
                </div>
			</div>
			<div class="form-group">
				<label>Nama <a class="text-red">*</a></label>
				@if($listBulan)
				<select name="bulan" id="bulan" class="form-control" required>
					<option value="">Pilih Bulan</option>
					@foreach($listBulan as $item)
					<option value="{{$item['value']}}">{{$item['name']}}</option>
					@endforeach
				</select>
				@else
				<select name="bulan" id="bulan" class="form-control" required>
					<option value="">Maaf, tidak ada data</option>
				</select>
				@endif
				@if($listMinggu)
				<select style="display: none;" name="minggu" id="minggu" class="form-control">
					<option value="">Pilih Minggu</option>
					@foreach($listMinggu as $item)
					<option value="{{$item['value']}}">{{$item['name']}}</option>
					@endforeach
				</select>
				@else
				<select style="display: none;" name="minggu" id="minggu" class="form-control" required>
					<option value="">Maaf, tidak ada data</option>
				</select>
				@endif
			</div>
			<button type="submit" class="btn btn-primary">Rekap</button>
		</form>
		
	</div>
</div>


@endsection
