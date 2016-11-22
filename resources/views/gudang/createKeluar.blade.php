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
<script src="//cdn.jsdelivr.net/accounting.js/0.3.2/accounting.js"></script>
<script src="{{asset('/plugins/datepicker/bootstrap-datepicker.js')}}"></script>

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
            $(wrapper).append('<div class="row" > <div class="col-md-2"><div class="form-group"><select name="id_barang[]" class="form-control select2" style="width: 100%;" id="minyak' + j + '" required><option value="">Pilih Barang</option> @foreach($barang as $item) <option value="{{$item->id}}" data-shrink="{{$item->shrink}}">{{$item->name}} ({{$item->unit}})</option> @endforeach </select></div></div><div class="col-md-2"><div class="form-group"><input type="text" name="jumlah[]" id="qty' + j + '" class="form-control" required></div></div><div class="col-md-2"> <div class="form-group">	<input type="text" name="harga[]" id="price' + j + '" class="form-control" required></div></div><div  class="col-md-2" ><select style="display:none;"  name="id_tank[]" class="form-control" id="tank' + j + '" ><option value="">Pilih Tangki</option>@foreach($tank as $item)<option value="{{$item->id}}">{{$item->name}}</option>@endforeach</select></div><input type="hidden" name="tipeA[]" value="Keluar"> <div class="col-md-1"><a href="#" class="btn btn-primary remove_field"><i class="icon fa fa-times"></i></a></div><div class="col-md-3"><span id="subTotal' + j +'"></span><input type="hidden" id="sub' + j +'" value="0"></div></div> </div>'); //add input box
            $("#minyak" + j + "").select2();
            $('#minyak' + j + '').on('change', function() {
		      if ($(this).find(':selected').data('shrink') == "1")
		      {
		        $('#tank' + $(this).attr('id').replace('minyak','') + '').show();
		        document.getElementById("tank" + $(this).attr('id').replace('minyak','') + "").required = true;
		      }
		      else
		      {
		      	document.getElementById("tank" + $(this).attr('id').replace('minyak','') + "").required = false;
		        $('#tank' + $(this).attr('id').replace('minyak','') + '').hide();
		      }
		    });
		    $('#qty' + j + '').on('keyup', function(e) {
		      var q = $(this).val();
		      var p = $('#price' + $(this).attr('id').replace('qty','') + '').val();
		      $('#subTotal' + $(this).attr('id').replace('qty','') + '').html(accounting.formatMoney(q*p, "Rp", 2, ".", ","));
		      $('#sub'+$(this).attr('id').replace('qty','')+'').val(q*p); 
		      hitungTotal();
		      $('#total').html(total); 
		    });
		    $('#price' + j + '').on('keyup', function(e) {
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
    // Show/Hide select Tangki
    $('#minyak').on('change', function() {
      if ($(this).find(':selected').data('shrink') == "1")
      {
        $("#tank").show();
        document.getElementById("tank").required = true;
      }
      else
      {
        document.getElementById("tank").required = false;
        $("#tank").hide();
      }
    });
    // Hitung total untuk view
    function hitungTotal(e){
    	// e.preventDefault(); 
    	total = 0;
    	// total = parseInt($('#sub'+x+'').val());
    	// // alert(x);
    	for(i=0;i<=j;i++){
    		if($('#sub'+i+'').val()){
    			total+=parseInt($('#sub'+i+'').val());
    		}

   		}
   		total = accounting.formatMoney(total, "Rp", 2, ".", ",");  
    }
    // perhitungan di field jumlah
    $('#qty').on('keyup', function() {
    	// alert(x);
      var q = $(this).val();
      var p = $('#price').val();

      $('#subTotal').html(accounting.formatMoney(q*p, "Rp", 2, ".", ","));
      $('#sub0').val(q*p); 
      hitungTotal();
      $('#total').html(total);
    });
    // perhitungan di field harga
    $('#price').on('keyup', function(e) {
      var p = $(this).val();
      var q = $('#qty').val();
      $('#subTotal').html(accounting.formatMoney(q*p, "Rp", 2, ".", ","));
      $('#sub0').val(q*p);
      hitungTotal();
      $('#total').html(total);  
    });
    // Jika deadline = 0, tampilkan jumlah bayar
    $('#partner').on('change', function() {
      if ($(this).find(':selected').data('deadline') == "0")
      {
        $("#pembayaran").show();
        $('#bayar').val(1); 
      }
      else
      {
        $("#pembayaran").hide();
        $('#bayar').val(0);
        $("[name='type']").removeAttr("required");
        $("[name='amount']").removeAttr("required");
      }
    });
    $('#giro').on('change', function() {
        if($(this).is(":checked")){
            	$('#giro_form').show();
            	$('#bank_form').hide();
            	$('#jumlah_form').hide();
            	$('#pilih_giro_form').hide();
            }
    });
    $('#transfer').on('change', function() {
        if($(this).is(":checked")){ 
           	$('#bank_form').show();
   			$('#giro_form').hide();
   			$('#jumlah_form').show();
   			$('#pilih_giro_form').hide();
   		}
    });
    $('#tunai').on('change', function() {
        if($(this).is(":checked")){
            	$('#giro_form').hide();
            	$('#bank_form').hide();
            	$('#jumlah_form').show();
            	$('#pilih_giro_form').hide();
            }
    });
    $('#pilih_giro').on('change', function() {
        if($(this).is(":checked")){
            	$('#giro_form').hide();
            	$('#bank_form').hide();
            	$('#jumlah_form').hide();
            	$('#pilih_giro_form').show();
            }
    });
});
	

</script>
@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Penjualan</h3>
		
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
		<form role="form" method="POST" action="{{route('gudang.store')}}">
			{!! csrf_field() !!}
			<div class="form-group">
			<input type="hidden" name="tipe" value="Keluar">
				<label>No Resi <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="no_resi" placeholder="No Resi" value="{{ old('no_resi') }}" onblur="checkUserName(this.value)" required>
				<span id="usercheck" style="padding-left:10px; ; vertical-align: middle;"></span>
			</div>
			<div class="form-group">
				<label>Customer <a class="text-red">*</a></label>
				<select name="partner_id" id="partner" class="form-control" required>
					<option value="">Pilih Customer</option>
					@foreach($customer as $item)
					<option value="{{$item->id}}" data-deadline="{{$item->payment_deadline}}">{{$item->company}} (CP : {{$item->name}})</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label>Tanggal <a class="text-red">*</a></label>
				<input type="text" class="form-control" id="datepicker" name="tanggal" placeholder="Tanggal" value="{{ old('tanggal') }}">
			</div>
			
			<div class="row">
				<div class="col-md-2"><label>Barang <a class="text-red">*</a></label></div>
				<div class="col-md-2"><label>Jumlah <a class="text-red">*</a></label></div>
				<div class="col-md-2"><label>Harga Satuan (IDR) <a class="text-red">*</a></label></div>
				<div class="col-md-2"><label>Tangki</label></div>
				<div class="col-md-1"></div>
				<div class="col-md-3"><label>Sub Total</label></div>
			</div>
			<div class="input_fields_wrap">
			<div class="row">
				<div class="col-md-2">
					<div class="form-group">	
						<select name="id_barang[]" class="form-control select2" style="width: 100%;" id="minyak" required>
							<option value="">Pilih Barang</option>
							@foreach($barang as $item)
							<option value="{{$item->id}}" data-shrink="{{$item->shrink}}">{{$item->name}} ({{$item->unit}})</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">	
						
						<input type="text" name="jumlah[]" id="qty" class="form-control" required>
					</div>
				</div>

				<div class="col-md-2">
					<div class="form-group">	
						<input type="text" name="harga[]" id="price" class="form-control" required>
					</div>	
				</div>
				<div  class="col-md-2" >
					<select style="display:none;" name="id_tank[]" class="form-control" id="tank">
							<option value="">Pilih Tangki</option>
							@foreach($tank as $item)
							<option value="{{$item->id}}">{{$item->name}}</option>
							@endforeach
					</select>
				</div>
				<input type="hidden" name="tipeA[]" value="Keluar">
				<div class="col-md-1">
					<a href="#" class="btn btn-primary remove_field"><i class="icon fa fa-times"></i></a>
				</div>
				<div class="col-md-3">
					<span id="subTotal"></span>
					<input type="hidden" id="sub0" value="0"></div>
				</div>
				
				</div>
				<div class="row">
					<div class="col-md-7"></div><div class="col-md-1"><label>Total:</label></div><div class="col-md-3"><span id="total"></span></div>
				</div>
				<section id="pembayaran" style="display:none;">
				<input type="hidden" value="0" id="bayar" name="bayar">
					<div class="form-group">
						<label>Pembayaran</label>
					</div>
					<div class="form-group">
					<label>Metode Pembayaran <a class="text-red">*</a></label>
					<div class="radio">
	                  <label>
	                    <input type="radio"  name="type" value="tunai" id="tunai"> Tunai
	                  </label>
	                </div>
	                <div class="radio">
	                  <label>
	                    <input type="radio"  name="type" value="transfer" id="transfer"> Transfer Bank
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
				</section>
				<a href="#" class="btn btn-primary add_field_button"><i class="icon fa fa-plus"></i></a>
				<button id="tambah" type="submit" class="btn btn-primary">Tambah Data</button> 

			</div>
			
		</form>
		
	</div>
</div>


@endsection

