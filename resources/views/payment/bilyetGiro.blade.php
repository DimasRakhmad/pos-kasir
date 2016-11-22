@extends('app')

@section('htmlheader_title')
Pencairan Giro
@endsection

@section('contentheader_title')
Pencairan Giro
@endsection

@section('additional_styles')
<!-- DATA TABLES -->
<link rel="stylesheet" href="{{asset('/plugins/datepicker/datepicker3.css')}}" />
@endsection

@section('additional_scripts')
<script src="{{asset('/plugins/datepicker/bootstrap-datepicker.js')}}"></script>

@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Pencairan Giro {{ $giro->no_giro }}</h3>

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
		<form role="form" method="POST" action="{{url('bilyetGiro',$giro->id)}}">
		{!! csrf_field() !!}
			<div class="form-group">
				<label>Bank </label>
				<select class="form-control" name="bank">
					<option value="">Pilih Bank</option>
					@foreach($banks as $bank)
					<option value="{{$bank->id}}">{{$bank->name}}</option>
					@endforeach
				</select>
			</div>
			<button type="submit" class="btn btn-primary">Cairkan</button>
		</form>

	</div>
</div>


@endsection
