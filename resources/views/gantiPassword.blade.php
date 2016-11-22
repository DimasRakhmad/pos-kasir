@section('ganti-pass')class="active" @stop
@extends('app')

@section('htmlheader_title')
Ganti Password
@endsection

@section('contentheader_title')
Ganti Password
@endsection

@section('additional_styles')
<!-- DATA TABLES -->

@endsection

@section('additional_scripts')

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
		<form role="form" method="POST" action="{{url('gantiPassword')}}">
			<div class="form-group">
				{!! csrf_field() !!}
				<label>Password Lama <a class="text-red">*</a></label>
				<input type="password" class="form-control" name="password_lama" placeholder="Password Lama" value="{{ old('password_lama') }}" required>
			</div>
			<div class="form-group">
				<label>Password Baru <a class="text-red">*</a></label>
				<input type="password" class="form-control" name="password_baru" placeholder="Password Baru" value="{{ old('password_baru') }}" required>
			</div>

			<div class="form-group">
				<label>Ulangi Password Baru <a class="text-red">*</a></label>
				<input type="password" class="form-control" name="password_baru_lagi" placeholder="Ulangi Password Baru" value="{{ old('password_baru_lagi') }}" required>
			</div>
			
			<button type="submit" class="btn btn-primary">Perbaharui Password</button>
		</form>
		
	</div>
</div>


@endsection
