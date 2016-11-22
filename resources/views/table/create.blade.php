@section('table-tree-link')class="active" @stop
@section('table-link')class="active" @stop
@extends('app')

@section('htmlheader_title')
Table
@endsection

@section('contentheader_title')
Table
@endsection

@section('additional_styles')
<!-- DATA TABLES -->

@endsection

@section('additional_scripts')

@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Add Table</h3>
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
		<form role="form" method="POST" action="{{route('table.store')}}">
			<div class="form-group">
				<label>Area <a class="text-red">*</a></label>
				<select class="form-control" name="area_id" required>
					<option>Pilih Area</option>
					@foreach($areas as $area)
					<option value="{{$area->id}}">{{$area->name}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				{!! csrf_field() !!}
				<label>Code <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="code" placeholder="Code" value="{{ old('code') }}" required>
			</div>
			<div class="form-group">
				<label>Name <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}" required>
			</div>
			<button type="submit" class="btn btn-primary">Add New</button>
		</form>
		
	</div>
</div>


@endsection
