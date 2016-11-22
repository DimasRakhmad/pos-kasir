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
		<h3 class="box-title">Update Table</h3>
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
		<form role="form" method="POST" action="{{route('table.update',$item->id)}}">
		<input type="hidden" name="_method" value="put">
			<div class="form-group">
				<label>Area <a class="text-red">*</a></label>
				<select class="form-control" name="area_id" required>
					@foreach ($area as $areas)
						@if($item->area_id == $areas->id)
							<option value="{{ $areas->id }}" selected>{{ $areas->name }}</option>
						@else
							<option value="{{ $areas->id }}">{{ $areas->name }}</option>
						@endif
					
					@endforeach
				</select>
			</div>
			<div class="form-group">
				{!! csrf_field() !!}
				<label>Code <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="code" placeholder="Code" value="{{ $item->code }}" required>
			</div>
			<div class="form-group">
				<label>Name <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="name" placeholder="Name" value="{{ $item->name }}" required>
			</div>
			<button type="submit" class="btn btn-primary">Update</button>
		</form>
		
	</div>
</div>


@endsection
