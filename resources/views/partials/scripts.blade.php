<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
<script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/js/app.min.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mousetrap/1.4.6/mousetrap.min.js" type="text/javascript"></script>
<script>

	// Menu Pembelian Ctrl+b
	Mousetrap.bind("alt+b", function() {
		window.location.replace("{{route('gudang.create')}}");
	});
	// Menu Penjualan Ctrl+z
	Mousetrap.bind("alt+j", function() {
		window.location.replace("{{url('gudang/createKeluar')}}");
	});
	// Menu Piutang Ctrl+i
	Mousetrap.bind("alt+i", function() {
		window.location.replace("{{url('piutang')}}");
	});
	// Menu Hutang Ctrl+r
	Mousetrap.bind("alt+d", function() {
		window.location.replace("{{url('hutang')}}");
	});

	// validasi
	function checkUserName(usercheck)
	{
		$('#usercheck').html("<img src='{{asset('img/loading.gif')}}'' />");
		$.get("{{url('cekNoResi')}}" + "/" + usercheck , function(data)
			{
					if (data.warning != '' || data.warning != undefined || data.warning != null)
				   {
					  $('#usercheck').html(data.warning);
				   }

				   if (data.status == true){
				   		$('#tambah').prop("disabled",true);
				   }else{
				   		$('#tambah').prop("disabled",false);
				   }
	          });
	}
</script>
@yield('additional_scripts')
<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
