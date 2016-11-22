@section('laporan-tree-link')class="treeview active" @stop
@section('penjualan')class="active" @stop
@extends('app')

@section('htmlheader_title')
    Laporan Jumlah Penjualan Menu
@endsection

@section('contentheader_title')
    Laporan Jumlah Penjualan Menu
    @endsection

    @section('additional_styles')
            <!-- DATA TABLES -->
    <link href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"/>
    @endsection

@section('additional_scripts')
        <!-- DATA TABES SCRIPT -->
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js" type="text/javascript"></script>
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}" type="text/javascript"></script>
    {{--<script src="https://code.jquery.com/jquery-1.12.3.js" type="text/javascript"></script>--}}
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js" type="text/javascript"></script>
    {{--<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js" type="text/javascript"></script>--}}

            <!-- page script -->
    <script type="text/javascript">
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

        $(function () {
            $('input[name="daterange"]').daterangepicker({
                        "locale": {
                            "format": 'D MMMM YYYY',
                            "firstDay": 1
                        }
                    },
                    function (start, end, label) {
                        window.location.href = "{{ url('r-menu') }}/" + start.format('YYYY-MM-DD') + "/" + end.format('YYYY-MM-DD');
                    });
        });
    </script>
@endsection

@section('main-content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Laporan Jumlah Penjualan Menu</h3>
            <div class="box-tools pull-right">
                {{--<a href="{{ url('exportTransMenu') }}" role="button" class="btn btn-xs btn-success"><i--}}
                            {{--class="fa fa-plus"> Export to Excel</i></a>--}}
            </div>
        </div>

        <div class="box-body">
            <form role="form">
                <div class="form-group">
                    <div class="row" id="tanggal">
                        <div class="col-md-4 col-md-offset-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i>
                                    </div>
                                    <input class="form-control" type="text" name="daterange" style="text-align:center"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <table id="item_table" class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Menu</th>
                    <th>Qty</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody id="row">
                <?php 
                    $total = 0;  
                    $total_qty = 0; 
                ?> 
                @foreach($data as $key => $value)
                <?php 
                    $total += $value->total; 
                    $total_qty += $value->qty;
                ?>
                <tr>
                    <td> {{ $key+1 }} </td>
                    <td> {{ $value->item->name }} </td>
                    <td> {{ $value->qty }} </td>
                    <td align="right"> {{ "Rp. " . number_format($value->total,0,",",".") }} </td>
                </tr>
                @endforeach
                <tr>  
                <td>  </td>
                <td> <b> Total </b> </td>
                <td> <b> {{ $total_qty }} </b> </td>
                <td align="right"> <b> {{ "Rp. " . number_format($total,0,",",".") }} </b> </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>


@endsection
