@extends('app')

@section('htmlheader_title')
Pembayaran Piutang
@endsection

@section('contentheader_title')
Pembayaran Piutang
@endsection

@section('additional_styles')
<!-- DATA TABLES -->
<link rel="stylesheet" href="{{asset('/plugins/datepicker/datepicker3.css')}}" />
@endsection

@section('additional_scripts')
<script src="{{asset('/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script>
	$(function() {
	    $("#datepicker").datepicker();
	});
	$(function() {
	    $("#datepicker2").datepicker();
	});
	$(document).ready(function(){

	    $('#giro').on('change', function() {
	        if($(this).is(":checked")){
	            	$('#giro_form').show();
	            	$('#bank_form').hide();
	            	$('#jumlah_form').hide();
	            }
	    });
	    $('#transfer').on('change', function() {
	        if($(this).is(":checked")){ 
	           	$('#bank_form').show();
	   			$('#giro_form').hide();
	   			$('#jumlah_form').show();
	   		}
	    });
	    $('#tunai').on('change', function() {
	        if($(this).is(":checked")){
	            	$('#giro_form').hide();
	            	$('#bank_form').hide();
	            	$('#jumlah_form').show();
	            }
	    });
	    
	});

</script>
@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		
		@if(count($min)!=0)
		<h3 class="box-title">{{ $tran->name }} ( Rp {{ number_format($tran->account[0]->pivot->amount+$min[0]->account[0]->pivot->amount, 2, ",", ".")}} ) </h3>
		@else
		<h3 class="box-title">{{ $tran->name }} ( Rp {{ number_format($tran->account[0]->pivot->amount, 2, ",", ".")}} ) </h3>
		@endif
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
		<form role="form" method="POST" action="{{url('bayarPiutang',$tran->id)}}">
			<div class="form-group">
				{!! csrf_field() !!}
				<input type="hidden" name="harus_bayar" value="{{abs($tran->account[0]->pivot->amount)}}" >
				<input type="hidden" name="account_id" value="{{$tran->account[0]->id}}">
				<label>Kode Transaksi <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="transaction_code" placeholder="Kode Transaksi" value="{{ old('transaction_code') }}" required>
			</div>
			
			<div class="form-group">
				<label>Metode Pembayaran <a class="text-red">*</a></label>
				<div class="radio">
                  <label>
                    <input type="radio"  name="type" value="tunai" id="tunai" required> Tunai
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio"  name="type" value="transfer" id="transfer" required> Transfer Bank
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio"  name="type" value="giro" id="giro" required> Giro
                  </label>
                </div>
			</div>
			<div class="form-group" id="bank_form" style="display:none;">
				<label>Bank </label>
				<select class="form-control" name="bank">
					<option value="">Pilih Bank</option>
					@foreach($types as $type)
					<option value="{{$type->id}}">{{$type->name}}</option>
					@endforeach
				</select>
			</div>
			<section id="giro_form" style="display:none;" >
			<div class="row">
				<div class="col-md-3"><label>Nomor Giro</label></div>
				<div class="col-md-3"><label>Nominal</label></div>
				<div class="col-md-2"><label>Tangal dibuat</label></div>
				<div class="col-md-2"><label>Tanggal Efektif</label></div>
				<div class="col-md-2"><label>Nama Bank</label></div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<input type="text" class="form-control" name="no_giro">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<input type="text" value="{{abs($tran->account[0]->pivot->amount)}}" id="nominal" class="form-control" name="nominal">
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<input type="text" id="datepicker" class="form-control" name="tanggal_dibuat">
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<input type="text" id="datepicker2" class="form-control" name="tanggal_efektif">
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<input type="text" class="form-control" name="nama_bank">
					</div>
				</div>
			</div>
			</section>
			<div class="form-group" id="jumlah_form">
				<label>Jumlah Pembayaran <a class="text-red">*</a></label>
				@if(count($min)!=0)
				<input value="{{abs($tran->account[0]->pivot->amount+$min[0]->account[0]->pivot->amount)}}" id="total" type="text" class="form-control" name="amount" placeholder="Jumlah Pembayaran" value="{{ old('amount') }}" >
				@else
				<input value="{{abs($tran->account[0]->pivot->amount)}}" id="total" type="text" class="form-control" name="amount" placeholder="Jumlah Pembayaran" value="{{ old('amount') }}" >
				@endif
			</div>
			<button type="submit" class="btn btn-primary">Tambah</button>
		</form>
		
	</div>
</div>


@endsection
