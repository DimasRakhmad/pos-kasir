@extends('app')

@if ($tran->account[0]->group_id == 7)
	<?php $title = "Hutang"; ?>
@else
	<?php $title = "Piutang"; ?>
@endif
@section('htmlheader_title')
Pembayaran {{ $title }}
@endsection

@section('contentheader_title')
Pembayaran {{ $title }}
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
	            	$('#pilih_giro_form').hide();
	            	$("[name='amount']").removeAttr("required");
	            	$("[name='giro_id']").removeAttr("required");
	            	$("[name='bank']").removeAttr("required");
	            }
	    });
	    $('#transfer').on('change', function() {
	        if($(this).is(":checked")){
	           	$('#bank_form').show();
	   			$('#giro_form').hide();
	   			$('#jumlah_form').show();
	   			$('#pilih_giro_form').hide();
	   			$("[name='giro_id']").removeAttr("required");
            	$("[name='no_giro']").removeAttr("required");
            	$("[name='nominal']").removeAttr("required");
            	$("[name='tanggal_dibuat']").removeAttr("required");
            	$("[name='tanggal_efektif']").removeAttr("required");
            	$("[name='nama_bank']").removeAttr("required");
	   		}
	    });
	    $('#tunai').on('change', function() {
	        if($(this).is(":checked")){
	            	$('#giro_form').hide();
	            	$('#bank_form').hide();
	            	$('#jumlah_form').show();
	            	$('#pilih_giro_form').hide();
	            	$("[name='giro_id']").removeAttr("required");
	            	$("[name='no_giro']").removeAttr("required");
	            	$("[name='nominal']").removeAttr("required");
	            	$("[name='tanggal_dibuat']").removeAttr("required");
	            	$("[name='tanggal_efektif']").removeAttr("required");
	            	$("[name='nama_bank']").removeAttr("required");
	            	$("[name='bank']").removeAttr("required");
	            }
	    });
	    $('#pilih_giro').on('change', function() {
	        if($(this).is(":checked")){
	            	$('#giro_form').hide();
	            	$('#bank_form').hide();
	            	$('#jumlah_form').hide();
	            	$('#pilih_giro_form').show();
	            	$("[name='amount']").removeAttr("required");
	            	$("[name='no_giro']").removeAttr("required");
	            	$("[name='nominal']").removeAttr("required");
	            	$("[name='tanggal_dibuat']").removeAttr("required");
	            	$("[name='tanggal_efektif']").removeAttr("required");
	            	$("[name='nama_bank']").removeAttr("required");
	            	$("[name='bank']").removeAttr("required");
	            }
	    });

	});

</script>
@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
	<?php $bayar=0; ?>
		@if(count($min)!=0)
			@foreach($min as $item)
				@foreach($item->account as $account)
				<?php $bayar+=$account->pivot->amount ?>
				@endforeach
			@endforeach
		<h3 class="box-title">{{$title}} {{ $tran->partner->name }} (Sisa: Rp {{ number_format(abs($tran->account[0]->pivot->amount+$bayar), 2, ",", ".")}} ) </h3>
		@else
		<h3 class="box-title">{{$title}} {{ $tran->partner->name }} (Sisa: Rp {{ number_format(abs($tran->account[0]->pivot->amount), 2, ",", ".")}} ) </h3>
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
		<form role="form" method="POST" action="{{url('bayarHutangPiutang',$tran->id)}}">
			<div class="form-group">
				<label>Tanggal <a class="text-red">*</a></label>
				<input type="text" class="form-control" id="datepicker" name="tanggal" placeholder="Tanggal" value="{{ old('tanggal') }}">
			</div>
			<div class="form-group">
				{!! csrf_field() !!}
				@if(count($min)!=0)
				<input type="hidden" name="harus_bayar" value="{{abs($tran->account[0]->pivot->amount+$bayar)}}" >
				@else
				<input type="hidden" name="harus_bayar" value="{{abs($tran->account[0]->pivot->amount)}}" >
				@endif

				<input type="hidden" name="account_id" value="{{$tran->account[0]->id}}">

				<label>Kode Transaksi <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="transaction_code" placeholder="No Resi" value="{{ old('transaction_code') }}" onblur="checkUserName(this.value)" required>
				<span id="usercheck" style="padding-left:10px; ; vertical-align: middle;"></span>
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
                    <input type="radio"  name="type" value="giro" id="giro" required> Giro Baru
                  </label>
                </div>
								@if($tran->account[0]->group_id == 7)
                <div class="radio">
                  <label>
                    <input type="radio"  name="type" value="pilih_giro" id="pilih_giro" required> Pilih Giro
                  </label>
                </div>
								@endif
			</div>
			<div class="form-group" id="pilih_giro_form" style="display:none;">
				<label>Pilih Giro </label>
				<select class="form-control" name="giro_id" >
					<option value="">Pilih Giro</option>
					@foreach($giro as $item)
					<option value="{{$item->id}}">{{$item->no_giro}} | Rp {{ number_format($item->nominal, 2, ",", ".")}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group" id="bank_form" style="display:none;">
				<label>Bank </label>
				<select class="form-control" name="bank" >
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
						<input type="text" class="form-control" name="no_giro" >
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<input type="text" class="form-control" name="nominal" id="nominal">
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<input type="text" id="datepicker" class="form-control" name="tanggal_dibuat" >
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<input type="text" id="datepicker2" class="form-control" name="tanggal_efektif" >
					</div>
				</div>
				@if ($title == "Hutang")
				<div class="col-md-2">
					<select class="form-control" name="nama_bank" >
					<option value="">Pilih Bank</option>
					@foreach($types as $type)
					<option value="{{$type->id}}">{{$type->name}}</option>
					@endforeach
				</select>
				</div>
				@else
				<div class="col-md-2">
					<div class="form-group">
						<input type="text" class="form-control" name="nama_bank">
					</div>
				</div>
				@endif
			</div>
			</section>
			<div class="form-group" id="jumlah_form">
				<label>Jumlah Pembayaran <a class="text-red">*</a></label>
				@if(count($min)!=0)
				
				<input id="total" type="text" value="{{abs($tran->account[0]->pivot->amount+$bayar)}}" class="form-control" name="amount" placeholder="Jumlah Pembayaran" value="{{ old('amount') }}">
				@else
				<input id="total" type="text" value="{{abs($tran->account[0]->pivot->amount)}}" class="form-control" name="amount" placeholder="Jumlah Pembayaran" value="{{ old('amount') }}">
				@endif

			</div>
			<button id="tambah" type="submit" class="btn btn-primary">Tambah</button>
		</form>

	</div>
</div>


@endsection
