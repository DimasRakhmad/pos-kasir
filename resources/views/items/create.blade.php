@section('stock-treeview')class="treeview active" @stop
@section('items')class="active" @stop
@extends('app')

@section('htmlheader_title')
    Barang
@endsection

@section('contentheader_title')
    Barang
@endsection

@section('additional_styles')
            <!-- DATA TABLES -->

@endsection

@section('additional_scripts')

@endsection

@section('main-content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Tambah Data Barang</h3>

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
            <p class="text-red"><b>Keterangan: (*) Wajib diisi</b></p>
            <form role="form" method="POST" action="{{route('items.store')}}">
                    {!! csrf_field() !!}
                <div class="form-group">
                    <label>Nama Barang<a class="text-red">*</a></label>
                    <input type="text" class="form-control" name="name" placeholder="Nama Barang"
                           value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label>Satuan<a class="text-red">*</a></label>
                    <input type="text" class="form-control" name="unit" placeholder="contoh: KG, Liter"
                           value="{{ old('unit') }}" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control" cols="20"
                              rows="5">{{ old('description') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Barang</button>
            </form>

        </div>
    </div>
@endsection
