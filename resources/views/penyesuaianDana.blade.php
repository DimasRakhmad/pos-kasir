@extends('app')

@section('htmlheader_title')
Penyesuaian Dana
@endsection

@section('contentheader_title')
Penyesuaian Dana
@endsection

@section('additional_styles')
<link rel="stylesheet" href="{{asset('/plugins/datepicker/datepicker3.css')}}" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />
@endsection

@section('additional_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
<script src="{{asset('/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script>
  $(".select2").select2();
  $(function() {
      $("#datepicker").datepicker();
  });
</script>
	
@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
      <h3 class="box-title">Penyesuaian Dana</h3>
    </div>
    <div class="box-body">
    @if(Session::has('gagal'))
    <div class="alert alert-danger alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <i class="icon fa fa-warning"></i>
      {{ Session::get('gagal') }}
    </div>
    @endif
    	<form role="form" method="POST" action="{{url('penyesuaian-dana')}}">
      <div class="form-group">
      
        <label>No Resi <a class="text-red">*</a></label>
        <input type="text" class="form-control" name="no_resi" placeholder="No Resi" value="{{ old('no_resi') }}" onblur="checkUserName(this.value)" required>
        <span id="usercheck" style="padding-left:10px; ; vertical-align: middle;"></span>
      </div>
      <div class="form-group">
        <label>Tanggal <a class="text-red">*</a></label>
        <input type="text" class="form-control" id="datepicker" name="tanggal" placeholder="Tanggal" value="{{ old('tanggal') }}">
      </div>
    		<div class="form-group">
    		{!! csrf_field() !!}
            <label>Pilih Akun <a class="text-red">*</a></label>
            <select name="akun" class="form-control select2" required>
              <option value="">Pilih Akun</option>
              @foreach($akun as $item)
              <option value="{{$item->id}}">{{$item->name}}</option>
              @endforeach
            </select>
        </div>

        <div class="form-group">
        <label>Jenis <a class="text-red">*</a></label>
          <div class="radio">
            <label>
              <input type="radio" name="tipe"  value="kredit" required>
              Kredit
            </label>
          </div>
          <div class="radio">
            <label>
              <input type="radio" name="tipe"  value="debit" required>
              Debit
            </label>
          </div>
        </div>
        <div class="form-group">
          <label for="">Jumlah Rupiah <a class="text-red">*</a></label>
          <input type="text" class="form-control" name="amount" required>
        </div>
        <div class="form-group">
          <label for="">Keterangan <a class="text-red">*</a></label>
          <input type="text" class="form-control" name="keterangan" required>
        </div>
            <button id="tambah" type="submit" class="btn btn-primary">Tambah</button>
	    </form>
    </div>
</div>
@endsection
