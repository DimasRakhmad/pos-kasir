@section('laporan-tree-link')class="treeview active" @stop
@section('pemasukan')class="active" @stop
@extends('app')

@section('htmlheader_title')
    Laporan Pemasukkan
@endsection

@section('contentheader_title')
    Pemasukkan
    @endsection
    @section('additional_styles')
            <!-- DATA TABLES -->
    <link href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css"/>
    <link href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" rel="stylesheet" type="text/css"/>
    @endsection

    @section('additional_scripts')
            <!-- DATA TABES SCRIPT -->
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js" type="text/javascript"></script>

    <!-- page script -->
    <script type="text/javascript">
        $(function () {
            $('input[name="daterange"]').daterangepicker({
                        "locale": {
                            "format": 'D MMMM YYYY',
                            "firstDay": 1
                        }
                    },
                    function (start, end, label) {
                        $.ajax({
                            method: "GET",
                            url: '/filter-income/' + start.format('YYYY-MM-DD') + "/" + end.format('YYYY-MM-DD'),
                            beforeSend: function () {
                                // load some loader
                            },
                            success: function (data) {
//                    console.log(data);
                                $('#row').children().remove();
                                $("#row").append(
                                        "<h3>" + 'Rp. ' + data + "</h3>"
                                );
                            }
                        });
                    });
        });
        function filter() {
            $.ajax({
                method: "GET",
                url: '/filter-income/',
                beforeSend: function () {
                    // load some loader
                },
                success: function (data) {
//                    console.log(data);
                    $('#row').children().remove();
                    $("#row").append(
                            "<h3>" + 'Rp. ' + data + "</h3>"
                    );
                }
            });
        }
    </script>
@endsection

@section('main-content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Laporan Pemasukkan</h3>
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
            <div class="col-md-12">
                <div class="col-md-4"><h3>Pemasukan</h3></div>
                <div class="col-md-1"><h3>:</h3></div>
                <div class="col-md-4" id="row"><h3>Rp. {{ $data}}</h3></div>
            </div>
        </div>
    </div>


@endsection
