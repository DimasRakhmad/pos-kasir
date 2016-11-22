@extends('app')

@section('htmlheader_title')
Biaya
@endsection

@section('contentheader_title')
Biaya
@endsection

@section('additional_styles')
<!-- DATA TABLES -->

@endsection

@section('additional_scripts')

@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Tambah Biaya</h3>
		
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
		<form role="form" method="POST" action="{{url('biaya')}}">
			<div class="form-group">
				<label>Tipe <a class="text-red">*</a></label>
				<div class="radio">
                  <label>
                    <input type="radio"  name="jenis" value="3" required> Biaya Operasional
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio"  name="jenis" value="4" required> Biaya Non Operasional
                  </label>
                </div>
			</div>
				{!! csrf_field() !!}

			<div class="form-group">
				<label>Nama Biaya <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="name" placeholder="Contoh : Listrik" value="{{ old('name') }}" required>
			</div>
			<div class="form-group">
				<label >Deskripsi</label>
				<textarea name="deskripsi" class="form-control" cols="20" rows="5">{{ old('deskripsi') }}</textarea>
			</div>
			<button type="submit" class="btn btn-primary">Tambah Biaya</button>
		</form>
		
	</div>
</div>


@endsection
