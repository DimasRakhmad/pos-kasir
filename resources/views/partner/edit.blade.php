@extends('app')

@section('htmlheader_title')
Partner
@endsection

@section('contentheader_title')
Partner
@endsection

@section('additional_styles')
<!-- DATA TABLES -->

@endsection

@section('additional_scripts')

@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Tambah Data Parnter</h3>
		
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
		<form role="form" method="POST" action="{{route('partner.update',$partner->id)}}">
		<input type="hidden" name="_method" value="put">
		{!! csrf_field() !!}
			<div class="form-group">
				<label>Tipe <a class="text-red">*</a></label>
				<div class="radio">
                  <label>
                  @if($partner->type == "Customer")
                  <input type="radio"  name="type" value="Customer" checked required> Customer
                  @else
                  <input type="radio"  name="type" value="Customer" required> Customer
                  @endif
                  </label>
                </div>
                <div class="radio">
                  <label>
                  @if($partner->type == "Supplier")
                  <input type="radio"  name="type" value="Supplier" checked required> Supplier
                  @else
                  <input type="radio"  name="type" value="Supplier" required> Supplier
                  @endif
                    
                  </label>
                </div>
			</div>
			<div class="form-group">
				<label>Perusahaan <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="company" placeholder="Nama Perusahaan" value="{{$partner->company}}" required>
			</div>
			<div class="form-group">
				<label>Nama Contact Person <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="name" placeholder="Nama Contact Person" value="{{$partner->name}}" required>
			</div>
			<div class="form-group">
				<label>Telepon Contact Person </label>
				<input type="text" class="form-control" name="phone" placeholder="Telepon Contact Person" value="{{$partner->phone}}" >
			</div>
			<div class="form-group">
				<label>Batas Jatuh Tempo <a class="text-red">*</a></label>
				<select name="payment_deadline" class="form-control">
					<option value="">Pilih Jatuh Tempo</option>
					@foreach($deadline as $item)
					@if($partner->payment_deadline == $item['value'])
					<option value="{{$item['value']}}" selected>{{$item['name']}}</option>
					@else
					<option value="{{$item['value']}}">{{$item['name']}}</option>
					@endif
					@endforeach
				</select>
			</div>
			
			<button type="submit" class="btn btn-primary">Perbaharui Partner</button>
		</form>
		
	</div>
</div>


@endsection
