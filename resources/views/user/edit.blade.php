@extends('app')

@section('htmlheader_title')
User
@endsection

@section('contentheader_title')
User
@endsection

@section('additional_styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />
@endsection

@section('additional_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>

@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Edit User</h3>
		
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
		<p class="text-red"> <b>Note: (*) Required</b></p>
		<form role="form" method="POST" action="{{route('user.update',$item->id)}}">
		<input type="hidden" name="_method" value="put">
			<div class="form-group">
				<label>Role <a class="text-red">*</a></label>
				<select name="role" id="" class="form-control">
					<option value="">Choose Role</option>
					@foreach($roles as $role)
					@if($item->roles[0]->id == $role->id)
					<option value="{{$role->id}}" selected>{{$role->name}}</option>
					@else
					<option value="{{$role->id}}">{{$role->name}}</option>
					@endif
					@endforeach
				</select>
			</div>
			<div class="form-group">
				{!! csrf_field() !!}
				<label>Name <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="name" placeholder="Name" value="{{ $item->name }}" required>
			</div>
			<div class="form-group">
				<label>Username <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="email" placeholder="Username" value="{{ $item->email }}" required>
			</div>
			<div class="form-group">
				<label>Password </label>
				<input type="password" class="form-control" name="password" placeholder="Password" >
			</div>
			
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
		
	</div>
</div>


@endsection
