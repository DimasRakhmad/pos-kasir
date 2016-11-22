@extends('app')

@section('htmlheader_title')
Penjualan
@endsection

@section('contentheader_title')
Penjualan
@endsection

@section('additional_styles')
<!-- DATA TABLES -->
<link href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('additional_scripts')
<!-- DATA TABES SCRIPT -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}" type="text/javascript"></script>



<script type="text/javascript">

	var id;
	var original_link = "/pembelian";
	$('#bulan').on('change', function(){
	    $('#filter').attr('href', original_link);
	    id = $(this).val();
	    var new_href = $('#filter').attr('href') + '/' + id;
	    $('#filter').attr('href', new_href);
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
		<div class="row">
				<div class="col-md-4 col-md-offset-4">

						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-calendar"></i>
								</div>

								<select name="bulan" class="form-control" id="bulan">
									<option value="">Pilih Bulan</option>
									@foreach($tigaBulan as $bulan)
										@if($bulan['m']==$date)
										<option value="{{$bulan['id']}}" selected>{{$bulan['name']}}</option>
										@else
										<option value="{{$bulan['id']}}">{{$bulan['name']}}</option>
										@endif

									@endforeach
								</select>
							</div>
						</div><center><a class="btn btn-primary" href="" id="filter">Filter</a> </center>


				</div>
			</div>
			@if($date==date('Y-m'))
				<label>Data per tangal <?php echo date('d-m-Y') ?></label>
			@endif
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Barang</th>
					<th><center>Jumlah</center></th>
				</tr>
			</thead>
			<tbody>
			<?php $i=0; $total = 0;  ?>
				@foreach ($items as $item)
				<?php $i++; ?>
				<tr>
					<td>{{$i}}</td>
					<td>{{$item->name }}</td>
					<td align="right">Rp {{ number_format(abs($item->jumlah), 2, ",", ".")}}</td>
					<?php $total+=$item->jumlah ?>
				</tr>
				@endforeach
				<tr>
					<td colspan="2" align="right">
						<label>Total</label>
					</td>
					<td align="right">
						Rp {{ number_format(abs($total), 2, ",", ".")}}
					</td>
				</tr>
			</tbody>
		</table>
		<a href="{{ url('exportPembelian',$date) }}" role="button" class="btn btn-xs btn-primary"><i class="fa fa-cloud-download"> xls</i></a>
	</div>
</div>


@endsection
