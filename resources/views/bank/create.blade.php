@extends('app')

@section('htmlheader_title')
Bank
@endsection

@section('contentheader_title')
Bank
@endsection

@section('additional_styles')
<!-- DATA TABLES -->

@endsection

@section('additional_scripts')

@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Tambah Data Bank</h3>
		
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
		<form role="form" method="POST" action="{{route('bank.store')}}">
			<div class="form-group">
				{!! csrf_field() !!}
				<label>Bank <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="name" placeholder="Bank" value="{{ old('name') }}" required>
			</div>
			<div class="form-group">
				<label>Type</label>
					<div class="radio">
	                  <label>
	                    <input type="checkbox"  name="kredit" value="true"> Kredit
	                  </label>
	                </div>
	                <div class="radio">
	                  <label>
	                    <input type="checkbox"  name="debit" value="true"> Debit
	                  </label>
	                </div>
			</div>
			<button type="submit" class="btn btn-primary">Tambah Mesin</button>
		</form>
		
	</div>
</div>


@endsection
