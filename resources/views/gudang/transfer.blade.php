@extends('app')

@section('htmlheader_title')
Tanki
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
		<h3 class="box-title">Transfer Tangki</h3>
		
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
		<form role="form" method="POST" action="{{url('transfer-tank')}}">
			<div class="form-group">
				{!! csrf_field() !!}
				<label>Dari <a class="text-red">*</a></label>
				<select type="text" class="form-control" name="dari" required>
					<option value="">Pilih Tangki</option>
					@foreach($tank as $item)
					<?php $total=0; ?>
						@foreach($item->gudang as $gudang)
						@if($gudang->amount_in)
						<?php $total+= $gudang->amount_in ?>
					
						@elseif($gudang->amount_out)
						<?php $total-= $gudang->amount_out ?>
						@endif
						@endforeach
						
					<option value="{{$item->id}}">{{$item->name}} ({{ $total }})</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label>Ke <a class="text-red">*</a></label>
				<select type="text" class="form-control" name="ke" required>
					<option value="">Pilih Tangki</option>
					@foreach($tank as $item)
					<?php $total=0; ?>
						@foreach($item->gudang as $gudang)
						@if($gudang->amount_in)
						<?php $total+= $gudang->amount_in ?>
					
						@elseif($gudang->amount_out)
						<?php $total-= $gudang->amount_out ?>
						@endif
						@endforeach
						
					<option value="{{$item->id}}">{{$item->name}} ({{ $total }})</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label >Jumlah</label>
				<input type="text" class="form-control" name="jumlah" placeholder="Jumlah" required>
			</div>
			<button type="submit" class="btn btn-primary">Transfer Minyak!</button>
		</form>
		
	</div>
</div>


@endsection
