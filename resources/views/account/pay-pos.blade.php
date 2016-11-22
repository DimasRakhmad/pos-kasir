@section('member-tree-link')class="active" @stop
@section('employee-link')class="active" @stop
@extends('kasir')

@section('htmlheader_title')
Member
@endsection

@section('contentheader_title')
Member
@endsection

@section('additional_styles')
<link rel="stylesheet" href="{{asset('/plugins/datepicker/datepicker3.css')}}" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />
@endsection

@section('additional_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
<script src="{{asset('/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript">
$(function() {
    $("#datepicker").datepicker();
});
</script>
@endsection

@section('main-content')
<?php $total =0;	?>
@foreach($item->accounting as $account)
	<?php $total+=$account->amount; ?>
@endforeach
<div class="box box-primary" style="font-size: 200%">
	<div class="box-header with-border">
		<h3 class="box-title">{{$item->name}} Total: Rp {{ number_format($total, 2, ",", ".")}}</h3>
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
		<form role="form" method="POST" action="{{url('pay-piutang-member-post-pos')}}">
			{!! csrf_field() !!}
			<input type="hidden" name="account_id" value="{{$item->id}}">
			<div class="form-group">
				<label>Kode Transaksi <a class="text-red">*</a></label>
				<input type="text" class="form-control input-lg" name="no_resi" placeholder="No Resi" value="{{ old('no_resi') }}" onblur="checkUserName(this.value)" required>
				<span id="usercheck" style="padding-left:10px; ; vertical-align: middle;"></span>
			</div>
			<div class="form-group">
				<label>Tanggal <a class="text-red">*</a></label>
				<input type="text" class="form-control input-lg" id="datepicker" name="tanggal" placeholder="Tanggal" value="{{ old('tanggal') }}" required>
			</div>
			<div class="form-group">	
				<label>Jumlah <a class="text-red">*</a></label>
				<input type="number" class="form-control input-lg" name="amount" placeholder="amount" value="{{ $total }}" required>
			</div>
			<button type="submit" class="btn btn-primary btn-lg">Submit</button>
		</form>
		
	</div>
</div>


@endsection
