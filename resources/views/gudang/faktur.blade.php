<html>
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="https://almsaeedstudio.com/themes/AdminLTE/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://almsaeedstudio.com/themes/AdminLTE/dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="https://almsaeedstudio.com/themes/AdminLTE/dist/css/skins/_all-skins.min.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<table width="100%" class="table">
					<tr>
						<td colspan="2">
							<h2>CV. Jaya Maju</h2>
							Jl. Stasiun No. 43 <br>
							Padalarang, Bandung Barat
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<h4><label>Faktur Penjualan</label></h4>
						</td>
					</tr>
					<tr>
						<td colspan=""><label>Tanggal:</label> {{$tanggal}}</td>
						<td colspan=""><label>No. Faktur :</label> {{$no_resi}}</td>
					</tr>
				</table>
				<table width="100%" class="table table-bordered" border="1 solid">
					<tr>
						<th>No.</th>
						<th>Nama Barang</th>
						<th>Jumlah</th>
						<th>Harga Satuan</th>
						<th>Sub Total</th>
					</tr>
					<?php $i=0 ;$total=0; ?>
					@foreach($data as $item)
					<?php $i++ ?>
					<tr>
						<td>{{$i}}</td>
						<td>{{$item['detail_barang']->name}}</td>
						<td>{{ number_format($item['jumlah'],0,'','.')}}</td>
						<td>Rp {{ number_format($item['harga'], 2, ",", ".")}}</td>
						<td>Rp {{ number_format($item['jumlah']*$item['harga'], 2, ",", ".")}}</td>
					</tr>
					<?php $total+=($item['jumlah']*$item['harga']) ?>
					@endforeach
					<tr>
						<td></td>
						<td colspan="2">Jatuh Tempo : {{date("d-m-Y", strtotime($tanggal."+ $partner->payment_deadline days"))}}</td>
						<td align="right"><label>Total : </label></td>
						<td>Rp {{ number_format($total, 2, ",", ".")}}</td>
					</tr>
					<tr>
						<td></td>
						<td align="center">
							Penerima,______
							<br><br><br>
							_______________
						</td>
						<td colspan="3"></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	window.onload = function () {
		window.print();
		window.location.replace("gudang");
	}
</script>
</body>
</html>