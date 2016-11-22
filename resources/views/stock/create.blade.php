@section('stock-treeview')class="treeview active" @stop
@section('stock')class="active" @stop
@extends('app')

@section('htmlheader_title')
Gudang
@endsection

@section('contentheader_title')
Gudang
@endsection

@section('additional_styles')
<!-- DATA TABLES -->
<link rel="stylesheet" href="{{asset('/plugins/datepicker/datepicker3.css')}}" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />
@endsection

@section('additional_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
<script src="{{asset('/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="//cdn.jsdelivr.net/accounting.js/0.3.2/accounting.js"></script>
<script type="text/javascript">
$(".select2").select2();
$(function() {
    $("#datepicker").datepicker();
});
$(function() {
    $("#datepicker1").datepicker();
});
$(function() {
    $("#datepicker2").datepicker();
});
$(document).ready(function() {
    var max_fields      = 99; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 0; //initlal text box count
    var j = 0;
    var total = 0;
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            j++;
           $(wrapper).append('<div class="row" > <div class="col-md-3"><div class="form-group"><select name="id_barang[]" class="form-control " id="select'+j+'" style="width: 100%;" required><option value="">Pilih Barang</option> @foreach($items as $item) <option value="{{$item->id}}" data-shrink="{{$item->shrink}}">{{$item->name}} ({{$item->unit}})</option> @endforeach </select></div></div><div class="col-md-2"><div class="form-group"><input type="number" name="jumlah[]" id="qty' + j + '" class="form-control" required></div></div><div class="col-md-3"> <div class="form-group">	<input type="number" name="harga[]" id="price' + j + '" class="form-control" required></div></div><div class="col-md-1"><a href="#" class="btn btn-danger remove_field"><i class="icon fa fa-times"></i></a></div><div class="col-md-3"><span id="subTotal' + j +'"></span><input type="hidden" id="sub' + j +'" value="0"></div></div> </div>'); //add input box
            $("#select" + j + "").select2();
		    $('#qty' + j + '').on('keyup', function() {
		      var q = $(this).val();
		      var p = $('#price' + $(this).attr('id').replace('qty','') + '').val();
		      $('#subTotal' + $(this).attr('id').replace('qty','') + '').html(accounting.formatMoney(q*p, "Rp", 2, ".", ","));
		      $('#sub'+$(this).attr('id').replace('qty','')+'').val(q*p); 
		      hitungTotal();
		      $('#total').html(total); 
		    });
		    $('#price' + j + '').on('keyup', function() {
		      var p = $(this).val();
		      var q = $('#qty' + $(this).attr('id').replace('price','') + '').val();
		      $('#subTotal' + $(this).attr('id').replace('price','') + '').html(accounting.formatMoney(q*p, "Rp", 2, ".", ","));
		      $('#sub'+$(this).attr('id').replace('price','')+'').val(q*p); 
		      hitungTotal();
		      $('#total').html(total); 
		    });
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent("div").parent("div").remove(); x--;
        hitungTotal();
        $('#total').html(total);
    });
    function hitungTotal(e){
    	// e.preventDefault(); 
    	total = 0;
    	// total = parseInt($('#sub'+x+'').val());
    	// // alert(x);
    	for(i=0;i<=j;i++){
    		if($('#sub'+i+'').val()== null){
    			total+=0;
    		}else{
    			total+=parseInt($('#sub'+i+'').val());
    		}
    		
   		}
   		total = accounting.formatMoney(total, "Rp", 2, ".", ",");  
   		
    }
    $('#qty').on('keyup', function() {
    	// alert(x);
      var q = $(this).val();
      var p = $('#price').val();
      $('#subTotal').html(accounting.formatMoney(q*p, "Rp", 2, ".", ","));
      $('#sub0').val(q*p); 
      hitungTotal();
      $('#total').html(total);
    });
    $('#price').on('keyup', function() {
      var p = $(this).val();
      var q = $('#qty').val();
      $('#subTotal').html(accounting.formatMoney(q*p, "Rp", 2, ".", ","));
      $('#sub0').val(q*p);
      hitungTotal();
      $('#total').html(total);  
    }); 
});
</script>
@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Pembelian</h3>
		
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
		<form role="form" method="POST" action="{{route('stock.store')}}">
			{!! csrf_field() !!}
			<input type="hidden" name="tipe" value="Masuk">
			<div class="form-group">
				<label>Kode Transaksi <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="no_resi" placeholder="No Resi" value="{{ old('no_resi') }}" onblur="checkUserName(this.value)" required>
				<span id="usercheck" style="padding-left:10px; ; vertical-align: middle;"></span>
			</div>
			<div class="form-group">
				<label>Supplier <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="supplier">
			</div>
			<div class="form-group">
				<label>Tanggal <a class="text-red">*</a></label>
				<input type="text" class="form-control" id="datepicker" name="tanggal" placeholder="Tanggal" value="{{ old('tanggal') }}">
			</div>
			<div class="row">
				<div class="col-md-3"><label>Barang <a class="text-red">*</a></label></div>
				<div class="col-md-2"><label>Jumlah <a class="text-red">*</a></label></div>
				<div class="col-md-3"><label>Harga Satuan (IDR) <a class="text-red">*</a></label></div>
				<div class="col-md-1"><a href="#" class="btn btn-primary add_field_button"><i class="icon fa fa-plus"></i></a></div>
				<div class="col-md-3"><label>Sub Total</label></div>
			</div>
			<br>
			<div class="input_fields_wrap">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">	
						<select name="id_barang[]" class="form-control select2" style="width: 100%;" id="minyak" required>
							<option value="">Pilih Barang</option>
							@foreach($items as $item)
							<option value="{{$item->id}}">{{$item->name}} ({{$item->unit}})</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">	
						<input type="number" name="jumlah[]" id="qty" class="form-control" required>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">	
						<input type="number" name="harga[]" id="price" class="form-control" required>
					</div>	
				</div>
				<div class="col-md-1">
					<a href="#" class="btn btn-danger remove_field"><i class="icon fa fa-times"></i></a>
				</div>
				<div class="col-md-3">
					<span id="subTotal"></span>
					<input type="hidden" id="sub0" value="">
				</div>
				
				</div>
				</div>
				<div class="row">
					<div class="col-md-8"></div><div class="col-md-1"><label>Total:</label></div><div class="col-md-3"><span id="total"></span></div>
				</div>
				
				<button id="tambah" type="submit" class="btn btn-primary">Tambah Data</button> 

		</form>
			</div>
			
		
	</div>
</div>


@endsection
