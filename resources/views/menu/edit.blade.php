@section('items-treeview')class="treeview active" @stop
@section('menu')class="active" @stop
@extends('app')

@section('htmlheader_title')
    Perbaharui Data Barang
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

});

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
            <h3 class="box-title">Perbaharui Data Barang</h3>

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
            <form role="form" method="POST" action="{{route('menu.update',$item->id)}}">
                <input type="hidden" name="_method" value="put">
                {!! csrf_field() !!}
                <div class="form-group" id="cat">
                    <label>Kategori <a class="text-red">*</a></label>
                    <select name="category_id" id="category" class="form-control">
                        @foreach($category as $CAT)
                            @if($CAT->id == $item->category_id)
                                <option value="{{$CAT->id}}" selected>{{$CAT->name}}</option>
                            @else
                                <option value="{{$CAT->id}}">{{$CAT->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Kode <a class="text-red">*</a></label>
                    <input type="text" class="form-control police" name="code" placeholder="Kode"
                           value="{{ $item->code }}" required>
                </div>
                <div class="form-group">
                    <label>Nama <a class="text-red">*</a></label>
                    <input type="text" class="form-control police" name="name" placeholder="Nama"
                           value="{{ $item->name }}" required>
                </div>
                <div class="form-group">
                    <label>Harga <a class="text-red">*</a></label>
                    <input type="number" class="form-control police" name="price" placeholder="Harga"
                           value="{{ $item->price }}" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control" cols="20"
                              rows="5">{{ $item->description }}</textarea>
                </div>

                <div class="form-group">
                    <label>Recipe</label>
                    @foreach($recipe as $key => $value)
                        <div>
                            <select name="item[]" >
                                <option selected disabled> Choose item </option>
                                @foreach($items  as $key1 => $value1)                                    
                                    <option value="{{ $value1->id }}" {{ $value->item_id == $value1->id ? 'selected' : '' }} > {{ $value1->name . " (" . $value1->unit . ")" }} </option>
                                @endforeach                    
                            </select>

                            <input type="text" name="recipe[]" value="{{ $value->amount }}">

                         </div> <br>
                    @endforeach

                    <div class="multi-field-wrapper">
                      <div class="multi-fields">
                        <div class="multi-field" style="margin-bottom:10px">
                          <select name="item[]" class="item">
                              <option selected disabled> Choose item </option>  
                              @foreach ($items as $key => $value)
                                  <option value="{{ $value->id }}" > {{ $value->name . " (" . $value->unit . ")" }} </option>  
                              @endforeach
                          </select>  
                        
                          <input type="text" name="recipe[]" placeholder="recipe">
                          <button type="button" class="remove-field">Remove</button>
                        </div>
                      </div>
                    <button type="button" class="add-field">Add field</button>
                    <br><br>
                  </div>

                </div>
                <button type="submit" class="btn btn-primary">Perbaharui Data</button>
            </form>

        </div>
    </div>


@endsection
