@section('stock-treeview')class="treeview active" @stop
@section('stock')class="active" @stop
@extends('app')

@section('htmlheader_title')
    Stok
@endsection

@section('contentheader_title')
    Stok
    @endsection

    @section('additional_styles')
            <!-- DATA TABLES -->
    <link href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css"/>
    @endsection

    @section('additional_scripts')
            <!-- DATA TABES SCRIPT -->
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}" type="text/javascript"></script>

    <!-- page script -->
    <script type="text/javascript">
        $(function () {
            $('#item_table').DataTable();
        });
    </script>
@endsection

@section('main-content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"></h3>
            <div class="box-tools pull-right">
                <a href="{{ route('stock.create') }}" role="button" class="btn btn-xs btn-primary"><i
                            class="fa fa-plus"> Tambah Stok</i></a>
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
                    <th>Tanggal</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items->stock as $key => $item)
                    @if($item->amount > 0)
                    <?php $amount = 0; ?>
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $item->date }}</td>
                        <td>
                            {{ $item->amount }}
                        </td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection
