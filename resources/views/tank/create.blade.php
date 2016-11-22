@extends('app')

@section('htmlheader_title')
Tangki
@endsection

@section('contentheader_title')
Tangki
@endsection

@section('additional_styles')
<!-- DATA TABLES -->

@endsection

@section('additional_scripts')
<script>
	$('#gudang').on('change', function() {
        if($(this).is(":checked")){
            	$('#supir').hide();
            	document.getElementById("supirForm").required = false;
            }else{
            	$('#supir').show();
            	document.getElementById("supirForm").required = true;
            }
    });
</script>

@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Tambah Data Tangki</h3>
		
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
		<form role="form" method="POST" action="{{route('tank.store')}}">
			<div class="form-group">
				<div class="checkbox">
                  <label>
                    <input type="checkbox"  id="gudang" name="stock" value="1"> Tanki Gudang
                  </label>
                </div>
			</div>
			<div class="form-group">
				{!! csrf_field() !!}
				<label>Nama Tangki <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="name" placeholder="Nama Tangki" value="{{ old('name') }}" required>
			</div>
			<div class="form-group" id="supir">
				<label>Supir <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="driver" placeholder="Supir" id="supirForm" value="{{ old('driver') }}" required>
			</div>
			<button type="submit" class="btn btn-primary">Tambah Tanki</button>
		</form>
		
	</div>
</div>


@endsection
