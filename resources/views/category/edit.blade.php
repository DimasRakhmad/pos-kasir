@extends('app')

@section('htmlheader_title')
Perbaharui Data Kategori
@endsection

@section('contentheader_title')
Kategori
@endsection

@section('additional_styles')
<!-- DATA TABLES -->

@endsection

@section('additional_scripts')

@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Perbaharui Data Kategori</h3>
		
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
		<form role="form" method="POST" action="{{route('category.update',$category->id)}}">
		<input type="hidden" name="_method" value="put">
			<div class="form-group">
				{!! csrf_field() !!}
				<label>Nama Kategori <a class="text-red">*</a></label>
				<input type="text" class="form-control police" name="name" placeholder="Nama Kategori" value="{{ $category->name }}" required>
			</div>
			<div class="form-group">
				<label >Deskripsi</label>
				<textarea name="description" class="form-control" cols="20" rows="5">{{ $category->description }}</textarea>
			</div>
			<div class="form-group">
				<label>Lokas Printer</label>
				<div class="radio">
                  <label>
                    <input type="radio"  name="print_location" @if($category->print_location == 'Dapur') checked @endif value="Dapur" required> Dapur
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio"  name="print_location" @if($category->print_location == 'Bar') checked @endif value="Bar" required> Bar
                  </label>
                </div>
			</div>
			<button type="submit" class="btn btn-primary">Perbaharui Data Kategori</button>
		</form>
		
	</div>
</div>


@endsection
