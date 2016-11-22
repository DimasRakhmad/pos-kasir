@extends('waiters')

@section('htmlheader_title')

@endsection

@section('contentheader_title')
    POS
@endsection

@section('additional_styles')

@endsection

@section('additional_scripts')

@endsection

@section('main-content')
    <div class="content">

        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-body">


                        <div class="row">
                            <div class="col-md-2">
                                <a href="{{url('/pilih')}}" class="btn btn-block btn-danger btn-lg">Cancel</a>
                            </div>
                            <div class="col-md-2 col-md-offset-4">
                                <a class="btn btn-block btn-primary btn-lg" onclick="save()">Save</a>
                            </div>
                            <div class="col-md-2">
                                {{--<form action="{{url('checkout')}}" method="post">--}}
                                    {{--{!!csrf_field()!!}--}}
                                    {{--<input type="hidden" name="id" value="{{$trans->id}}">--}}
                                    {{--<button type="submit" class="btn btn-block btn-primary btn-lg">Checkout</button>--}}
                                {{--</form>--}}

                            </div>
                            <div class="col-md-2">
                                {{--<a class="btn btn-block btn-primary btn-lg" data-toggle="modal"--}}
                                   {{--data-target="#modalPay">Pay</a>--}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="col-md-12 bg-block bg-primary bg-lg"
                                       style="font-size: 200%">{{$table->name}}</label>
                            </div>
                            <div class="col-md-4">
                                <label class="col-md-12 bg-block bg-primary bg-lg"
                                       style="font-size: 200%">{{$trans->status_order}}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="col-md-12 bg-block bg-primary bg-lg text-right" style="font-size: 200%"
                                       id="t_amount"></label>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="item_table" class="table table-hover table-striped">
                                    <thead style="font-size:150%">
                                    <tr>
                                        <th>Product</th>
                                        <th width="10%">Qty</th>
                                        <th width="15%">Note</th>
                                        <th>Price</th>
                                        <th width="10%">Disc %</th>
                                        <th>Discount</th>
                                        <th>Amount</th>
                                        <th width="5%">#</th>
                                    </tr>
                                    </thead>
                                    <tbody style="font-size: 130%" id="menu">
                                    @foreach ($menus as $menu)
                                        <tr>
                                            <td>{{$menu->item->name}}</td>
                                            <td>{{$menu->qty}}</td>
                                            <td>{{$menu->note}}</td>
                                            <td>Rp. {{$menu->item->price}}</td>
                                            <td>{{($menu->discon / ($menu->amount + $menu->discon)) * 100}}</td>
                                            <td>Rp. {{$menu->discon}}</td>
                                            <td>Rp. {{$menu->amount}}</td>
                                        </tr>
                                    @endforeach
                                    {!! csrf_field() !!}
                                    <input type="hidden" id="table" value="{{$table->id}}">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row" style="font-size: 120%">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label>Order No</label>
                                    </div>
                                    <div class="col-md-7"><label>:</label>
                                        <input type="hidden" id="transid" value="{{$trans->id}}">{{$trans->code}}
                                        <input type="hidden" name="_token" id="token"
                                               value="<?php echo csrf_token(); ?>"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <label>Waiter</label>
                                    </div>
                                    <div class="col-md-7"><label>:</label> {{session('nama')}}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Subtotal</label>
                                    </div>
                                    <div class="col-md-6"><label>:</label>
                                        <label id="subtotal"></label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Disc %</label>
                                    </div>
                                    <div class="col-md-1">
                                        <label>:</label></div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" value="0" id="t_disc">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Discount</label>
                                    </div>
                                    <div class="col-md-6"><label>:</label>
                                        <label id="t_discount"></label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Total</label>
                                    </div>
                                    <div class="col-md-6"><label>:</label>
                                        <label id="total"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row" id="deliv">
                                    {{--<div class="col-md-6">--}}
                                        {{--<label>Delivery Cost</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-1">--}}
                                        {{--<label>:</label></div>--}}
                                    {{--<div class="col-md-4">--}}
                                        {{--<input type="text" class="form-control" value="0" id="dlv">--}}
                                    {{--</div>--}}
                                </div>
                                <div class="row">
                                    {{--<div class="col-md-12">--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label>Manager</label>--}}
                                            {{--<select class="form-control" name="employee">--}}
                                                {{--<option disabled selected>Select Manager</option>--}}
                                                {{--@foreach($manager as $value)--}}
                                                    {{--<option value="{{ $value->id }}"> {{ $value->name }} </option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}


                                    {{--<div class="col-md-12">--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label>Password<a class="text-red">:</a></label>--}}
                                            {{--<input type="password" class="form-control" name="auth"--}}
                                            {{-->--}}
                                        {{--</div>--}}
                                    {{--</div>--}}


                                    {{--<div class="col-md-12">--}}
                                        {{--<div class="form-group">--}}
                                            {{--<button type="submit" disabled class="btn btn-info ">Check</button>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- style="pointer-events:none;" -->
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <span style="font-size:150%" class="box-title"><b>Product Categories</b></span>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4" style="padding:10px;">
                                <a class="btn btn-block btn-primary btn-lg" onclick="filter('*')">All</a>
                            </div>
                            <!-- style="pointer-events:none;" -->
                            @foreach ($cats as $cat)
                                <div class="col-md-4" style="padding:10px;">
                                    <a class="btn btn-block btn-primary btn-lg"
                                       onclick="filter({{ $cat->id }})">{{ $cat->name }}</a>
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <div class="box-header with-border">
                        <span style="font-size:150%" class="box-title"><b>Product Items</b></span>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12" id="item">
                                @if($trans->checkout != 'true')
                                    @foreach ($items as $item)
                                        <a class="btn btn-block btn-default btn-flat  btn-lg"
                                           onclick="choose({{$item->id}})">{{$item->name}}</a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Begin Modal Delete -->
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Attention!!</h4>
                </div>
                <div class="modal-body">
                    <center>Are you sure? ?</center>
                </div>
                <div class="modal-footer">
                    <form action="" method="post">
                        <input type="hidden" name="_method" value="delete">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </form>
                    <button type="button" class="btn btn-default " data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Delete -->

    <!-- Begin Modal Payment -->
    <div class="modal fade" id="modalPay" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Attention!!</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="{{ url('transaction/pay') }}">
                        <div class="form-group">
                            {!! csrf_field() !!}
                            <label>Payment Method <a class="text-red">:</a></label>
                            <div>
                                <button type="button" data-type="cash" class="btn pay_type btn-success btn-lg cash"
                                        onclick="$('#byr').show('slow');$('#kmbl').show('slow');$('#emp').hide('slow');$('.adm').hide('slow')">
                                    Cash
                                </button>
                                <button type="button" data-type="credit" class="btn btn-info pay_type btn-lg"
                                        onclick="$('#byr').hide('slow');$('#kmbl').hide('slow');$('#emp').hide('slow');$('.adm').show('slow')">
                                    Credit
                                </button>
                                <button type="button" data-type="debet" class="btn btn-info pay_type btn-lg"
                                        onclick="$('#byr').hide('slow');$('#kmbl').hide('slow');$('#emp').hide('slow');$('.adm').show('slow')">
                                    Debet
                                </button>
                                <button type="button" data-type="postpone" class="btn btn-info btn-lg pay_type"
                                        onclick="$('#byr').hide('slow');$('#kmbl').hide('slow');$('#emp').show('slow');$('.adm').hide('slow')">
                                    Postpone
                                </button>
                                <button type="button" data-type="compliment" class="btn btn-info btn-lg pay_type"
                                        onclick="$('#byr').hide('slow');$('#kmbl').hide('slow');$('#emp').hide('slow');$('.adm').hide('slow')">
                                    Compliment
                                </button>
                                <button type="button" data-type="void" class="btn btn-info btn-lg pay_type"
                                        onclick="$('#byr').hide('slow');$('#kmbl').hide('slow');$('#emp').hide('slow');$('.adm').hide('slow')">
                                    Void
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Grand Total<a class="text-red">:</a></label>
                            <input type="number" class="form-control" name="ttl" id="ttl" readonly>
                        </div>
                        <div class="form-group" id="byr">
                            <label>Payment<a class="text-red">:</a></label>
                            <input type="number" class="form-control input" name="bayar" id="bayar"
                                   value="0" >
                        </div>

                        <input type="hidden" name="id" value="{{$trans->id}}">
                        <input type="hidden" name="type" id="type" value="cash">
                        <input type="hidden" name="discount" id="disc">

                        <div class="form-group adm">
                            <label>Bank<a class="text-red">:</a></label>
                            <select class="form-control banks input" name="bank_id">
                                <option disabled selected>Select Manager</option>
                                @foreach($bank as $value)
                                    <option value="{{ $value->id }}"
                                            onclick="$('#bl').hide('slow');$('#bl1').hide('slow');"> {{ $value->name }} </option>
                                @endforeach
                                <option value="0" onclick="$('#bl').show('slow');$('#bl1').show('slow');"> bank lain</option>
                            </select>
                            {{--<input class="form-control banks input" name="bank">--}}
                        </div>

                        <div class="form-group adm">
                            <label id="bl">Bank Lain<a class="text-red">:</a></label>
                            <input id="bl1" type="text" class="form-control banks input" name="bank_lain">
                        </div>
                        <div class="form-group adm">
                            <label>Biaya Admin<a class="text-red">:</a></label>
                            <input type="number" class="form-control banks input" name="admin"
                                   value="0">
                        </div>

                        <div class="form-group" id="kmbl">
                            <label>Change<a class="text-red">:</a></label>
                            <input type="number" class="form-control input" name="kembali" id="kembali"
                                   value="0" readonly>
                        </div>

                        <div class="form-group" id="emp">
                            <label>Employee</label>
                            <select class="form-control input" name="employee" id="emps">
                                <option disabled selected>Choose Employee</option>
                                @foreach($emp as $value)
                                    <option value="{{ $value->id }}"> {{ $value->name }} </option>
                                @endforeach
                            </select>
                        </div>


                </div>
                <div class="modal-footer">

                    {!! csrf_field() !!}
                    <button type="submit" disabled class="btn btn-info subm">Submit</button>
                    </form>
                    {{--<button type="button" class="btn btn-default " data-dismiss="modal">--}}
                    {{--Cancel--}}
                    {{--</button>--}}
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Delete -->

    <script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            var data;
            var cRequest = null;
            var cR = null;
            var subst = 0;
            var t_discount = 0;
            var t_amount = 0;
            $('#deliv').hide('slow');
            $('#emp').hide('slow');
            $('#bl').hide('slow');
            $('#bl1').hide('slow');
            $('.adm').hide('slow');

            $('#t_disc').val(0);
            $('#dlv').val(0);
            cRequest = $.ajax({
                method: "GET",
                url: '/subtotal/' + $('#transid').val(),
                data: {},
                beforeSend: function () {
                    if (cRequest != null) {
                        cRequest.abort();
                    }
                },
                success: function (data) {
                    subst = data;
                    $('#subtotal').html('Rp. ' + data);
                    t_discount = subst * ($('#t_disc').val() / 100);
                    t_amount = parseInt(subst - t_discount);
                    $('#t_discount').html('Rp. ' + t_discount);
                    $('#total').html('Rp. ' + t_amount);
                    $('#t_amount').html('Rp. ' + t_amount);
                    $('#ttl').val(t_amount);
                },
                error: function (data) {
                    console.log(data);
                }
            });

            $('#bayar').keyup(function () {
                var change = $('#bayar').val() - $('#ttl').val();
                $('#kembali').val(change);

                if (change >= 0) {
                    $(".subm").prop('disabled', false);
                } else {
                    $(".subm").prop('disabled', true);
                }

            });

            $('#t_disc').keyup(function () {
                t_discount = subst * ($('#t_disc').val() / 100);
                t_amount = parseInt(subst - t_discount);
                $('#t_discount').html('Rp. ' + t_discount);
                $('#total').html('Rp. ' + t_amount);
                $('#t_amount').html('Rp. ' + t_amount);
                $('#ttl').val(t_amount);
                $('#disc').val(t_discount);
            });

            $('#dlv').keyup(function () {
                t_discount = subst * ($('#t_disc').val() / 100);
                t_amount = parseInt(subst - t_discount);
                $('#t_discount').html('Rp. ' + t_discount);
                $('#total').html('Rp. ' + t_amount);
                $('#t_amount').html('Rp. ' + t_amount);
                $('#ttl').val(t_amount);
            });

            $('.pay_type').click(function () {
                $(".pay_type").addClass('btn-info');
                $(this).removeClass('btn-info');
                $(this).addClass('btn-success');

                data = $(this).data('type').toString();

                if (data == 'cash') {
                    $(".subm").prop('disabled', true);
                } else {
                    $(".subm").prop('disabled', false);
                }


                $("#type").val(data);
                $('.input').removeAttr('required');
                if (data == "cash") {
                    $('.bayar').attr('required', 'required');
                } else if ((data == "credit") || (data == "debet")) {
                    $('.banks').attr();
                } else if (data == "postpone") {
                    $('#emps').attr('required', 'required');
                }
            });

//            $('#pay').click(function () {
//                cR = $.ajax({
//                    method: "PUT",
//                    url: '/bayar/' + $('#transid').val(),
//                    data: {
//                        _token: $('#token').val(),
//                        discon: t_discount,
//                        amount: t_amount,
//                    },
//                    beforeSend: function () {
//                        if (cR != null) {
//                            cR.abort();
//                        }
//                    },
//                    success: function (data) {
//                        window.location = '/pilih';
//                    },
//                    error: function (data) {
//
//                    }
//                });
//            })

        });

        var currentRequest = null;
        var subs = 0;
        var food = [];
        var discount = 0;
        var amount = 0;

        function stts() {
            if ($("select[name='status']").val() == 'delivery') {
                $('#deliv').show('slow');
            }
            else {
                $('#deliv').hide('slow');
            }
        }

        function choose(id) {
            $.ajax({
                method: "GET",
                url: '/items/' + id,
                data: {},
                beforeSend: function () {
                    // load some loader
                },
                success: function (data) {
                    var d = new Date();
                    var e = data.id + d.getSeconds() + d.getMilliseconds();

                    $("#menu").append("<tr id='" + e + "'><td><input type='hidden' id='item" + e + "' value='" + data.id + "'>" + data.name + "</td>" +
                            "<td><input type='text' name='qty' id='qty" + e + "' value='1' onkeyup='price(" + e + ")' class='form-control input-lg'></td>" +
                            "<td><input type='text' name='note' id='note" + e + "' class='form-control input-lg'></td>" +
                            "<td><input type='hidden' id='harga" + e + "' value='" + data.price + "'>Rp. " + data.price + "</td>" +
                            "<td><input type='text' name='disc' id='disc" + e + "' value='0' onkeyup='price(" + e + ")' class='form-control input-lg'></td>" +
                            "<td id='discount" + e + "'><input type='hidden' id='discountid" + e + "' value='0'>Rp. 0</td>" +
                            "<td id='amount" + e + "'><input type='hidden' id='amountid" + e + "' value='" + data.price + "'>Rp. " + data.price + "</td>" +
                            "<td><a href='#' onclick='cancel(" + e + ")' role='button' class='btn btn-block btn-danger'>-</a></td></tr>"
                    );

                    food.push(data.id + d.getSeconds() + d.getMilliseconds());
                }
            });
        }

        function filter(id) {
            $("#item").children().remove();
            $.getJSON("/items-by-cat/" + id, function (data) {
                var jumlah = data.length;
                $.each(data.slice(0, jumlah), function (i, data) {
                    $("#item").append("<a class='btn btn-block btn-default btn-flat  btn-lg' onclick='choose(" + data.id + ")'>" + data.name + "</a>")
                })
            });
        }

        function cancel(id) {
            var select = '#' + id;
            $("#menu").children(select).remove();
            var index = food.indexOf(id);
            food.splice(index, 1);
        }

        function price(id) {
            var qty = '#qty' + id;
            var disc = '#disc' + id;
            var discountid = '#discount' + id;
            var amountid = '#amount' + id;
            var hargaid = '#harga' + id;

            discount = (parseInt($(qty).val()) * parseInt($(hargaid).val())) * (parseInt($(disc).val()) / 100);
            amount = (parseInt($(qty).val()) * parseInt($(hargaid).val())) - discount;
            if (isNaN(discount) || isNaN(amount)) {
                $(discountid).html('Rp. 0');
                $(amountid).html('Rp. 0');
            }
            else {
                $(discountid).html('Rp. ' + discount);
                $(amountid).html('Rp. ' + amount);
                $(discountid).append("<input type='hidden' id='discountid" + id + "' value='" + discount + "'>");
                $(amountid).append("<input type='hidden' id='amountid" + id + "' value='" + amount + "'>");

                var sub = 0;
                currentRequest = $.ajax({
                    method: "GET",
                    url: '/subtotal/' + $('#transid').val(),
                    data: {},
                    beforeSend: function () {
                        if (currentRequest != null) {
                            currentRequest.abort();
                        }
                    },
                    success: function (data) {
//                        sub += parseInt(data);
//                        for (var i = 0; i <= food.length - 1; i++) {
//                            var aid = '#amountid' + food[i];
//                            sub += parseInt($(aid).val());
//                            subs = sub;
//                            $('#subtotal').html('Rp. ' + subs);
//                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }

        function save(meja) {
            for (var i = 0; i <= food.length - 1; i++) {
                var iid = '#item' + food[i];
                var nid = '#note' + food[i];
                var aid = '#amountid' + food[i];
                var did = '#discountid' + food[i];
                var qid = '#qty' + food[i];
                var tid = '#transid';
//                console.log($(iid).val());
//                console.log($(nid).val());
//                console.log($(aid).val());
//                console.log($(did).val());
//                console.log($(qid).val());
//                console.log($(tid).val());
                var posting = $.post('/order', {
                    _token: $('#token').val(),
                    transaction_id: $(tid).val(),
                    note: $(nid).val(),
                    items_id: $(iid).val(),
                    discon: $(did).val(),
                    amount: $(aid).val(),
                    qty: $(qid).val()
                });
                posting.done(function (data) {
                    location.reload();
                });
            }
        }

        function bayar(transaksi) {

        }
    </script>
@endsection

