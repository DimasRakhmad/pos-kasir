	<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
	<link href='https://fonts.googleapis.com/css?family=Play:400,700' rel='stylesheet' type='text/css'>
	<style type="text/css">
		body {
			font-family: 'Play', sans-serif;
			font-size: 75%;
		}
		h3 {
			font-size: 150%;
		}
		h4 {
			margin-bottom: 0;
		}
		h6	{
			margin-top: 0;
		}
	</style>
</head>
<body>
<h3><center><b>Pelangi</b></center></h3>
<center> cabang </center>
<center>Alamat</center>
<center>Phone</center>
<br>
<h4><center>Invoice</center></h4>
<h6><center>{{ $trans->code }}</center></h6>

<table width="100%">
	<tr>
		<td> No </td>
		<td> Product </td>
		<td> Quantity </td>		
		<td> Amount </td>
	</tr>

	@foreach($trans->detail as $key => $value)
	<tr>
		<td> {{ $key+1 }} </td>
		<td> {{ $value->item->name }} </td>
		<td> {{ $value->qty }} </td>		
		<td> {{ $value->amount }} </td>
	</tr>
	@endforeach
</table>

<br>
<center><b>Cashier</b></center>
<center> {{ Auth::user()->name }} </center>
<br>
<center>Thank you!</center>
<br>
<center>  </center>
<br>
<br>
<script type="text/javascript">
	window.onload = function () {
		window.print();
		window.location.replace("../pilih");
	}
</script>
</body>
</html>