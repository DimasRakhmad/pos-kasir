@section('laporan-tree-link')class="treeview active" @stop
@section('r-trans')class="active" @stop
@extends('app')

@section('htmlheader_title')
    Laporan Jumlah Transaksi
@endsection

@section('contentheader_title')
    Laporan Jumlah Transaksi
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
                            "daysOfWeek": [
                                "Mg",
                                "Sn",
                                "Sl",
                                "Rb",
                                "Km",
                                "Jm",
                                "Sb"
                            ],
                            "monthNames": [
                                "Januari",
                                "Februari",
                                "Maret",
                                "April",
                                "Mei",
                                "Juni",
                                "Juli",
                                "Agustus",
                                "September",
                                "Oktober",
                                "November",
                                "Desember"
                            ],
                            "firstDay": 1
                        }
                    },
                    function (start, end, label) {
                        window.location.href = "{{ url('r-trans') }}/" + start.format('YYYY-MM-DD') + "/" + end.format('YYYY-MM-DD');
                    });
        });

        $('input[name="daterange"]').on("dp.change", function (e) {
            alert('dfdf');
        });

        $(".edit").click(function(){
            var code = $(this).data('code').toString();
            var id = $(this).data('id').toString();
            $(".modal-title").html('Transaksi ' + code);
            $(".modal-body").load("{{ url('transaction/detail') }}/" + id);
        });

       
    </script>
@endsection

@section('main-content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Laporan Jumlah Transaksi</h3>
            {{--<div class="box-tools porder_typeull-right">--}}
                {{--<a href="{{ url('exportTrans') }}" role="button" class="btn btn-xs btn-success"><i--}}
                            {{--class="fa fa-plus"> Export to Excel</i></a>--}}
            {{--</div>--}}
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
                                    <input class="form-control" id="date" type="text" name="daterange" style="text-align:center"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @foreach($count as $key => $value)
                <div class="col-md-12">
                    <div class="col-md-4"><h4>{{ $value->order_type }}</h4></div>
                    <div class="col-md-1"><h4>:</h4></div>
                    <div class="col-md-4" id="row"><h4>{{ $value->count}}</h4></div>
                </div>
            @endforeach
            
          <table id="item_table" class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Transaction Code</th>
                    <th>Order Type</th>
                    <th>Pay Type</th>
                    <th>Amount</th>
                    <th>Time</th>
                    <th>#</th>
                </tr>
                </thead>
                <tbody id="row">
                @foreach($trans as $key => $value)
                <tr>
                    <td> {{ $key+1 }} </td>
                    <td> {{ $value->code }} </td>
                    <td> {{ $value->sales->order_type }} </td>
                    <td> {{ $value->sales->pay_type }} </td>
                    <td> {{ "Rp. " . number_format($value->total,0,",",".") }} </td>
                    <td> {{ date('d F Y H:i:s',strtotime($value->created_at)) }} </td>
                    <td> <a data-toggle="modal" data-target="#editModal" data-code="{{ $value->code }}" data-id="{{ $value->id }}" class="btn btn-primary edit btn-xs"><i class="fa fa-list "></i> Detail </a> </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel"> </h4>
      </div>
      <div class="modal-body">      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>     
    </div>
  </div>
</div>

@endsection
