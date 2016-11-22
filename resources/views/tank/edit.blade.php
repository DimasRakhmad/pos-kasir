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
		<form role="form" method="POST" action="{{route('tank.update',$tank->id)}}">
			<div class="form-group">
				<div class="checkbox">
                  <label>
                  @if($tank->stock==1)
                  <input type="checkbox"  name="stock" value="1" checked> Tanki Gudang
                  @else
                  <input type="checkbox"  name="stock" value="1"> Tanki Gudang
                  @endif
                    
                  </label>
                </div>
			</div>
			<div class="form-group">
				{!! csrf_field() !!}
				<input type="hidden" name="_method" value="put">
				<label>Nama Tangki <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="name" placeholder="Nama Barang" value="{{$tank->name}}" required>
			</div>
			<div class="form-group">
				<label>Supir (Kosongkan jika tangki gudang)</label>
				<input type="text" class="form-control" name="driver" placeholder="Satuan" value="{{$tank->driver}}" >
			</div>
			<button type="submit" class="btn btn-primary">Perbaharui Data</button>
		</form>
		
	</div>
</div>


@endsection
