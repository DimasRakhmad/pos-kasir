@section('items-treeview')class="treeview active" @stop
@section('menu')class="active" @stop
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
<script type="text/javascript">

var items = [];
var unit = [];

$('.multi-field-wrapper').each(function() {
    var $wrapper = $('.multi-fields', this);
    $(".add-field", $(this)).click(function(e) {
        $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
        fill();
    });
    $('.multi-field .remove-field', $wrapper).click(function() {
        if ($('.multi-field', $wrapper).length > 1)
            $(this).parent('.multi-field').remove();
    });

    $('.multi-field .item', $wrapper).change(function() {
        fill();        
    });
});

//initiate items data
$(function () {     
    $.ajax({
        url: "{{ url('get/item')}}",    
        success: function (data) {
            items = data;
            fill();
        }
    });   
});

//fill unit data
function fill(){   
    unit = [];

    var index;
    
    $('select[name^="item"]').each(function() {    
        var u = getUnit($(this).val());  
        unit.push(u);        
    });

    index = 0;
    $('input[name^="unit"]').each(function() {    
        $(this).val(unit[index]);
        index++;    
    });
}

//get unit per id
function getUnit(id){
    for (var i = 0; i < items.length; i++) {
        if (items[i].id == id) {
            return items[i].unit;
        }
    }
}



</script>

@endsection

@section('main-content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Tambah Menu</h3>
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
            <form role="form" method="POST" action="{{route('menu.store')}}">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label>Kategori <a class="text-red">*</a></label>
                    <select name="category_id" require  class="form-control">
                        <option value="">Pilih Kategori</option>
                        @foreach($category as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Kode<a class="text-red">*</a></label>
                    <input type="text" class="form-control" name="code" placeholder="Kode "
                           value="{{ old('code') }}" required>
                </div>
                <div class="form-group">
                    <label>Nama<a class="text-red">*</a></label>
                    <input type="text" class="form-control" name="name" placeholder="Nama "
                           value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label>Harga<a class="text-red">*</a></label>
                    <input type="number" class="form-control" name="price" placeholder="Harga "
                           value="{{ old('price') }}" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control" cols="20"
                              rows="5">{{ old('description') }}</textarea>
                </div>

                 <label>Resep</label>
                    <div class="multi-field-wrapper">
                      <div class="multi-fields">
                        <div class="multi-field" style="margin-bottom:10px">
                          <select name="item[]" class="item">
                              @foreach ($items as $key => $value)
                                  <option value="{{ $value->id }}" > {{ $value->name }} </option>  
                              @endforeach
                          </select>  
                        
                          <input type="text" name="unit[]" size="10" readonly>

                          <input type="text" name="recipe[]" placeholder="recipe">
                          <button type="button" class="remove-field">Remove</button>
                        </div>
                      </div>
                    <button type="button" class="add-field">Add field</button>
                    <br><br>
                  </div>

                <button type="submit" class="btn btn-primary">Tambah Baru</button>
            </form>

        </div>
    </div>
@endsection
