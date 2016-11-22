@section('stock-treeview')class="treeview active" @stop
@section('items')class="active" @stop
@extends('app')

@section('htmlheader_title')
    Daftar Barang
@endsection

@section('contentheader_title')
    Barang
    @endsection

    @section('additional_styles')
            <!-- DATA TABLES -->
    <link href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"/>
    @endsection

    @section('additional_scripts')
            <!-- DATA TABES SCRIPT -->


    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}" type="text/javascript"></script>
    {{--<script src="https://code.jquery.com/jquery-1.12.3.js" type="text/javascript"></script>--}}
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js" type="text/javascript"></script>
    {{--<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js" type="text/javascript"></script>--}}

            <!-- page script -->
    <script type="text/javascript">
        //        $(function () {
        //            $('#item_table').DataTable();
        //        });
        //        $(document).ready( function() {
        $('#item_table').DataTable( {
            dom: 'Bfrtip',
            buttons: [ {
                extend: 'excelHtml5',
                customize: function( xlsx ) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];

                    $('row c[r^="C"]', sheet).attr( 's', '2' );
                }
            } ]
        } );
        //        } );
    </script>
@endsection

@section('main-content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Barang</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('items.create') }}" role="button" class="btn btn-xs btn-primary"><i
                            class="fa fa-plus"> Tambah Barang</i></a>
                {{--<a href="{{ url('exportitems') }}" role="button" class="btn btn-xs btn-success"><i--}}
                            {{--class="fa fa-plus"> Export to Excel</i></a>--}}
            </div>
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

            <table id="item_table" class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Barang</th>
                    <th>Satuan</th>
                    <th>Deskripsi</th>
                    <th></th>


                </tr>
                </thead>
                <tbody>
                @foreach ($items as $key => $item)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->description }}</td>
                        <td>
                            <a href="{{route('items.edit',$item->id)}}" role="button" class="btn btn-xs btn-success"><i
                                        class="icon fa fa-edit"></i> Edit</a>
                            <a href="#" role="button" class="btn btn-xs btn-danger" data-toggle="modal"
                               data-target="#modalDelete{{$item->id}}"><i class="icon fa fa-edit"></i> Delete</a>
                        </td>

                    </tr>

                    <!-- Begin Modal Delete -->
                    <div class="modal fade" id="modalDelete{{$item->id}}" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Perhatian!!</h4>
                                </div>
                                <div class="modal-body">
                                    <center>Anda yakin akan menghapus barang {{$item->name}} ?</center>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{route('items.destroy',$item->id)}}" method="post">
                                        <input type="hidden" name="_method" value="delete">
                                        {!! csrf_field() !!}
                                        <button type="submit" class="btn btn-danger">Ya</button>
                                    </form>
                                    <button type="button" class="btn btn-default " data-dismiss="modal">Tidak</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal Delete -->
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection
