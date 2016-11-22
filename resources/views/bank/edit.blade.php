@extends('app')

@section('htmlheader_title')
Perbaharui Data Bank
@endsection

@section('contentheader_title')
Bank
@endsection

@section('additional_styles')
<!-- DATA TABLES -->

@endsection

@section('additional_scripts')

@endsection

@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Perbaharui Data Bank</h3>
		
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
		<form role="form" method="POST" action="{{route('bank.update',$bank->id)}}">
		<input type="hidden" name="_method" value="put">
			<div class="form-group">
				{!! csrf_field() !!}
				<label>Nama Bank <a class="text-red">*</a></label>
				<input type="text" class="form-control police" name="name" placeholder="Nama Bank" value="{{ $bank->name }}" required>
			</div>
			<div class="form-group">
				<label>Type</label>
					<div class="radio">
	                  <label>
	                  	@if($bank->account_kredit_id === NULL)
	                    <input type="checkbox"  name="kredit" value="true"> Kredit
	                    @else
	                    <input type="checkbox"  name="kredit" value="true" checked> Kredit
	                    @endif
	                  </label>
	                </div>
	                <div class="radio">
	                  <label>
	                    @if($bank->account_debit_id === NULL)
	                    <input type="checkbox"  name="debit" value="true"> Debit
	                    @else
	                    <input type="checkbox"  name="debit" value="true" checked> Debit
	                    @endif
	                  </label>
	                </div>
			</div>
			<button type="submit" class="btn btn-primary">Perbaharui Data Bank</button>
		</form>
		
	</div>
</div>


@endsection
