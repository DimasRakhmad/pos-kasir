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
		<form role="form" method="POST" action="{{url('uangJalan',$id)}}">
			<div class="form-group">
				
				<label>No. Resi <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="transaction_code" placeholder="No Resi" value="{{ old('transaction_code') }}" onblur="checkUserName(this.value)" required>
				<span id="usercheck" style="padding-left:10px; ; vertical-align: middle;"></span>
			</div>
			<div class="form-group">
				{!! csrf_field() !!}
				<label>Nominal <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="amount" placeholder="Nominal" value="{{ old('amount') }}" required>
			</div>
			<div class="form-group">
				<label>Sumber </label>
				<select name="account_id" class="form-control">
					<option value="">Pilih Akun</option>
					@foreach($akun as $item)
					<option value="{{$item->id}}">{{$item->name}}</option>
					@endforeach
				</select>
			</div>
			<button type="submit" class="btn btn-primary">Tambah Tanki</button>
		</form>
		
	</div>
</div>


@endsection
