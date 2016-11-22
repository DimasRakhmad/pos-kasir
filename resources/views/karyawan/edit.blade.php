@extends('app')

@section('htmlheader_title')
Karyawan
@endsection

@section('contentheader_title')
Karyawan
@endsection

@section('additional_styles')
<!-- DATA TABLES -->

@endsection

@section('additional_scripts')

@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Ubah Data Karyawan</h3>
		
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
		<form role="form" method="POST" action="{{route('karyawan.update',$karyawan->id)}}">
			<div class="form-group">
				<label>Tipe <a class="text-red">*</a></label>
				<div class="radio">
                  <label>
                  @if($karyawan->type=="Bulanan")
                    <input type="radio"  name="type" value="Bulanan" checked required> Bulanan
                  @else
                  	<input type="radio"  name="type" value="Bulanan" required> Bulanan
                  @endif
                  </label>
                </div>
                <div class="radio">
                  <label>
                  @if($karyawan->type=="Mingguan")
                    <input type="radio"  name="type" value="Mingguan" checked required> Mingguan
                  @else
                  	<input type="radio"  name="type" value="Mingguan" required> Mingguan
                  @endif
                  </label>
                </div>
			</div>
			<div class="form-group">
				{!! csrf_field() !!}
				<input type="hidden" name="_method" value="put">
				<label>Nama <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="nama" placeholder="Nama " value="{{ $karyawan->nama }}" required>
			</div>
			<div class="form-group">
				<label>Alamat <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="alamat" placeholder="Alamat" value="{{ $karyawan->alamat }}" required>
			</div>
			<div class="form-group">
				<label>Nomor HP <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="no_hp" placeholder="Nomor HP " value="{{ $karyawan->no_hp }}" required>
			</div>
			<div class="form-group">
				<label>Gaji Pokok <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="gaji_pokok" placeholder="Gaji Pokok" value="{{ $karyawan->gaji_pokok }}" required>
			</div>
			<div class="form-group">
				<label>Potongan Absen <a class="text-red">*</a></label>
				<input type="text" class="form-control" name="potongan_absen" placeholder="Potongan Absen" value="{{ $karyawan->potongan_absen }}" required>
			</div>
			<button type="submit" class="btn btn-primary">Ubah Karyawan</button>
		</form>
		
	</div>
</div>


@endsection
