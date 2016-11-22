@extends('app')

@section('htmlheader_title')
Akun
@endsection

@section('contentheader_title')
Akun
@endsection

@section('additional_styles')
<!-- DATA TABLES -->

@endsection

@section('additional_scripts')

@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Transfer Dana</h3>
		
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
		<form role="form" method="POST" action="{{url('transferDana')}}">
			<div class="form-group">
				{!! csrf_field() !!}
				<label>Dari <a class="text-red">*</a></label>
				<select type="text" class="form-control" name="dari" required>
					<option value="">Pilih Akun</option>
					@foreach($items as $item)
					<?php $saldo = 0; ?>
						@foreach ($item->transaction as $trans)
						<?php $saldo += $trans->pivot->amount; ?>
						@endforeach
						<?php if ($item->accountGroup->normal_balance == 'Kredit') $saldo = $saldo*-1 ?>
						
						
					<option value="{{$item->id}}">{{$item->name}} (@if ($saldo < 0)
						(Rp {{ number_format($saldo*-1, 2, ",", ".")}})
						@else
						Rp {{ number_format($saldo, 2, ",", ".")}}
						@endif)</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label>Ke <a class="text-red">*</a></label>
				<select type="text" class="form-control" name="ke" required>
					<option value="">Pilih Akun</option>
					@foreach($items as $item)
					<?php $saldo = 0; ?>
						@foreach ($item->transaction as $trans)
						<?php $saldo += $trans->pivot->amount; ?>
						@endforeach
						<?php if ($item->accountGroup->normal_balance == 'Kredit') $saldo = $saldo*-1 ?>
						
						
					<option value="{{$item->id}}">{{$item->name}} @if ($saldo < 0)
						(Rp {{ number_format($saldo*-1, 2, ",", ".")}})
						@else
						Rp {{ number_format($saldo, 2, ",", ".")}}
						@endif</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label >Jumlah</label>
				<input type="text" class="form-control" name="jumlah" placeholder="Jumlah" required>
			</div>
			<button type="submit" class="btn btn-primary">Transfer Dana!</button>
		</form>
		
	</div>
</div>


@endsection
