@extends('app')

@section('htmlheader_title')
Gudang
@endsection

@section('contentheader_title')
Gudang
@endsection

@section('additional_styles')
<!-- DATA TABLES -->

@endsection

@section('additional_scripts')

@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Data @if($gudang->tipe =="Masuk") Pembelian @else Penjualan @endif</h3>

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
		<form role="form" method="POST" action="{{route('gudang.update',$gudang->id)}}">
		<input type="hidden" name="_method" value="put">
			{!! csrf_field() !!}
			<div class="form-group">
				<label>Barang <a class="text-red">*</a></label>
				<select name="id_barang" class="form-control" required>
					@foreach($barang as $item)
					@if($item->id == $gudang->item_id)
					<option value="{{$item->id}}" selected>{{$item->name}}</option>
					@else
					<option value="{{$item->id}}">{{$item->name}}</option>
					@endif
					@endforeach
				</select>
			</div>
			@if($gudang->barang->shrink==1)
			<div class="form-group">
				<label>Tangki</label>
				<select name="id_tank" class="form-control" required>
					@foreach($tank as $item)
					@if($item->id == $gudang->tank_id)
					<option value="{{$item->id}}" selected>{{$item->name}}</option>
					@else
					<option value="{{$item->id}}">{{$item->name}}</option>
					@endif
					@endforeach
				</select>
			</div>
			@endif
			<div class="form-group">
				<label>Jumlah <a class="text-red">*</a></label>
				<input type="text" name="jumlah" class="form-control" @if($gudang->amount_in) value="{{$gudang->amount_in}}" @else value="{{$gudang->amount_out}}""
				@endif
				required>
			</div>
			@if ($gudang->price != null)
			<div class="form-group">
				<label>Harga (IDR) <a class="text-red">*</a></label>
				<input type="text" name="harga" value="{{$gudang->unit_price}}" class="form-control" required>
			</div>
			@endif
			<input type="hidden" name="tipe" value="{{$gudang->type}}">
			<button type="submit" class="btn btn-primary">Perbaharui Data</button>
		</form>

	</div>
</div>


@endsection
