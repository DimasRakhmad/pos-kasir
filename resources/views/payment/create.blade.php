@extends('app')

@section('htmlheader_title')
Bank
@endsection

@section('contentheader_title')
Bank
@endsection

@section('additional_styles')
	
@endsection

@section('additional_scripts')
	
@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
      <h3 class="box-title">Form Bank Baru</h3>
    </div>
    <div class="box-body">
    @if(Session::has('gagal'))
    <div class="alert alert-danger alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <i class="icon fa fa-warning"></i>
      {{ Session::get('gagal') }}
    </div>
    @endif
    	<form role="form" method="POST" action="{{route('bank.store')}}">
    		<div class="form-group">
    		{!! csrf_field() !!}
              <label>Nama Bank</label>
              <input type="text" class="form-control police" name="name" placeholder="Nama Bank" value="{{ old('name') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
	    </form>
    </div>
</div>
@endsection
