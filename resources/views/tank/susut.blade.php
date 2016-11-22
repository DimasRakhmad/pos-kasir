@extends('app')

@section('htmlheader_title')
Tangki
@endsection

@section('contentheader_title')
Tangki
@endsection

@section('additional_styles')
<link rel="stylesheet" href="{{asset('/plugins/datepicker/datepicker3.css')}}" />
@endsection

@section('additional_scripts')
<script src="{{asset('/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script>
	$(function() {
	    $("#datepicker").datepicker();
	});
</script>
@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Susut</h3>
		
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
		<form role="form" method="POST" action="{{url('susut')}}">
			<div class="form-group">
				<label>Tanggal <a class="text-red">*</a></label>
				<input type="text" class="form-control" id="datepicker" name="tanggal" placeholder="Tanggal" value="{{ old('tanggal') }}">
			</div>
			<div class="form-group">
				{!! csrf_field() !!}
				<label>Pilih Tangki <a class="text-red">*</a></label>
				<select name="tank_id" class="form-control" required>
					<option value="">Pilih Tangki</option>
					@foreach($tank as $item)
					<?php $total=0; ?>
						@foreach($item->gudang as $gudang)
						@if($gudang->amount_in)
						<?php $total+= $gudang->amount_in ?>
					
						@elseif($gudang->amount_out)
						<?php $total-= $gudang->amount_out ?>
						@endif
						@endforeach
					<option value="{{$item->id}}">{{$item->name}} ({{$total}})</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label>Jumlah Susut <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="jumlah" placeholder="Jumlah Susut" value="{{ old('jumlah') }}" required>
			</div>
			<button type="submit" class="btn btn-primary">Susut</button>
		</form>
		
	</div>
</div>


@endsection
