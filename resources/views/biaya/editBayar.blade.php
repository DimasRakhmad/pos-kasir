@extends('app')

@section('htmlheader_title')
Biaya
@endsection

@section('contentheader_title')
Biaya
@endsection

@section('additional_styles')
<!-- DATA TABLES -->
<link rel="stylesheet" href="{{asset('/plugins/datepicker/datepicker3.css')}}" />
@endsection

@section('additional_scripts')
<script src="//cdn.jsdelivr.net/accounting.js/0.3.2/accounting.js"></script>
<script src="{{asset('/plugins/datepicker/bootstrap-datepicker.js')}}"></script>

<script type="text/javascript">
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
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = <?php echo count($items->transactionDetails)-1; ?>; //initlal text box count
    var j = <?php echo count($items->transactionDetails)-1; ?>;
    var total = 0;
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            j++;
            $(wrapper).append('<div class="row"><div class="col-md-3">					<div class="form-group"><select name="item[' + x +'][id_biaya]" class="form-control" id="minyak" required>							<option value="">Pilih Jenis Biaya</option>							@foreach($biaya as $item)								<option value="{{$item->id}}">{{$item->name}}</option>@endforeach</select></div></div><div class="col-md-3"><div class="form-group"><input type="text" name="item[' + x +'][deskripsi]" class="form-control" required></div></div>				<div class="col-md-3"><div class="form-group">	<input type="text" name="item[' + x +'][amount]" id="subtotal' + x +'" class="form-control" required><input type="hidden" id="sub' + x +'" value="0"></div>	</div><div class="col-md-2">					<a href="#" class="btn btn-primary remove_field"><i class="icon fa fa-times"></i>				</div></div>'); //add input box
           
		    $('#subtotal' + x + '').on('keyup', function(e) {
		      var q = $(this).val();
		      $('#sub' + x + '').val(q); 
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
    
    // Hitung total untuk view
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
    // perhitungan di field jumlah
    $('#subtotal0').on('keyup', function() {
    	// alert(x);
      var q = $(this).val();
      $('#sub0').val(q); 
      hitungTotal();
      $('#total').html(total);
    });

    @foreach($items->transactionDetails as $key => $value)
    // Show/Hide select Tangki
    $('#minyak{{$key}}').on('change', function() {
      if ($(this).find(':selected').data('shrink') == "1")
      {
        $("#tank{{$key}}").show();
      }
      else
      {
        $("#tank{{$key}}").hide();
      }
    });
    
    // perhitungan di field jumlah
    $('#qty{{$key}}').on('keyup', function() {
    	// alert(x);
      var q = $(this).val();
      var p = $('#price{{$key}}').val();

      $('#subTotal{{$key}}').html(accounting.formatMoney(q*p, "Rp", 2, ".", ","));
      $('#sub{{$key}}').val(q*p); 
      hitungTotal();
      $('#total').html(total);
    });
    // perhitungan di field harga
    $('#price').on('keyup', function(e) {
      var p = $(this).val();
      var q = $('#qty').val();
      $('#subTotal{{$key}}').html(accounting.formatMoney(q*p, "Rp", 2, ".", ","));
      $('#sub{{$key}}').val(q*p);
      hitungTotal();
      $('#total').html(total);  
    });
    @endforeach
    
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
		<h3 class="box-title"></h3>
		
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
		<form role="form" method="POST" action="{{url('edit-detil-biaya',$items->id)}}">
		<input type="hidden" name="_method" value="put">
			{!! csrf_field() !!}
			<div class="form-group">
			<input type="hidden" name="tipe" value="Keluar">
				<label>No Resi <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="no_resi" placeholder="No Resi" value="{{ $items->transaction_code }}"  required>
				<span id="usercheck" style="padding-left:10px; ; vertical-align: middle;"></span>
			</div>
			<div class="form-group">
				<label>Tanggal <a class="text-red">*</a></label>
				<input type="text" class="form-control" id="datepicker" name="tanggal" placeholder="Tanggal" value="{{ $items->transaction_date }}">
			</div>
			<div class="form-group">
				<label>Sumber Dana <a class="text-red">*</a></label>
				<select name="sumber_id" id="partner" class="form-control" required>
					<option value="">Pilih Sumber Dana</option>
					@foreach($akun as $item)
						@if($items->sumber->account_id == $item->id)
						<option value="{{$item->id}}" selected>{{$item->name}}</option>
						@else
						<option value="{{$item->id}}">{{$item->name}}</option>
						@endif
					@endforeach
				</select>
			</div>
			
			
			<div class="row">
				<div class="col-md-3"><label>Jenis Biaya <a class="text-red">*</a></label></div>
				<div class="col-md-3"><label>Deskripsi <a class="text-red">*</a></label></div>
				<div class="col-md-3"><label>Jumlah<a class="text-red">*</a></label></div>
				<div class="col-md-2"></div>
			</div>
			<div class="input_fields_wrap">
			@foreach($items->transactionDetails as $key => $value)
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">	
						<select name="item[{{$key}}][id_biaya]" class="form-control" id="minyak{{$key}}" required>
							<option value="">Pilih Jenis Biaya</option>
							@foreach($biaya as $item)
								@if($value->account_id == $item->id)
								<option value="{{$item->id}}" selected>{{$item->name}}</option>
								@else
								<option value="{{$item->id}}">{{$item->name}}</option>
								@endif
							@endforeach
							
							
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">	
						
						<input type="text" name="item[{{$key}}][deskripsi]" value="{{$value->keterangan}}" class="form-control" required>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">	
						<input type="text" name="item[{{$key}}][amount]" id="subtotal0" value="{{$value->amount}}" class="form-control" required>
						<input type="hidden" id="sub{{$key}}" value="{{$value->amount}}">
					</div>	
				</div>
				<div class="col-md-2">
					<a href="#" class="btn btn-primary add_field_button"><i class="icon fa fa-plus"></i></a>
				</div>
				</div>
				@endforeach
				</div>
				<div class="row">
					<div class="col-md-7"></div><div class="col-md-1"><label>Total:</label></div><div class="col-md-3"><span id="total"></span></div>
				</div>
				
				<button id="tambah" type="submit" class="btn btn-primary">Tambah Data</button> 
			</div>
			
		</form>
		
	</div>
</div>


@endsection

