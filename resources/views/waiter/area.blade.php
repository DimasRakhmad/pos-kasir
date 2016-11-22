@extends('area')

@section('htmlheader_title')

@endsection

@section('contentheader_title')
    {{ session('level') }}
@endsection

@section('additional_styles')

@endsection

@section('additional_scripts')

@endsection

@section('main-content')
    <div class="content">


        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            @foreach ($items as $key => $item)
                                <div class="col-md-4" style="padding:10px;">
                                    <a style="font-size: 300%" href="{{url('waiter',$item->id)}}"
                                       class="btn btn-block btn-success btn-lg">{{ $item->name }}</a>
                                </div>
                            @endforeach
                            {{--<div class="col-md-4">--}}
                            {{--<a style="font-size: 300%" href="{{url('waiters')}}"--}}
                            {{--class="btn btn-block btn-success btn-lg">{{ $item->name }}</a>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-4">--}}
                            {{--<a style="font-size: 300%" href="{{url('waiters')}}"--}}
                            {{--class="btn btn-block btn-success btn-lg">{{ $item->name }}</a>--}}
                            {{--</div>--}}
                        </div>
                        <br>
                        {{--<div class="row">--}}
                        {{--<div class="col-md-4">--}}
                        {{--<a style="font-size: 300%" href="{{url('waiters')}}"--}}
                        {{--class="btn btn-block btn-success btn-lg">Table 1</a>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-4">--}}
                        {{--<a style="font-size: 300%" href="{{url('waiters')}}"--}}
                        {{--class="btn btn-block btn-success btn-lg">Table 2</a>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-4">--}}
                        {{--<a style="font-size: 300%" href="{{url('waiters')}}"--}}
                        {{--class="btn btn-block btn-success btn-lg">Table 3</a>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<br>--}}
                        {{--<div class="row">--}}
                        {{--<div class="col-md-4">--}}
                        {{--<a style="font-size: 300%" href="{{url('waiters')}}"--}}
                        {{--class="btn btn-block btn-success btn-lg">Table 1</a>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-4">--}}
                        {{--<a style="font-size: 300%" href="{{url('waiters')}}"--}}
                        {{--class="btn btn-block btn-success btn-lg">Table 2</a>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-4">--}}
                        {{--<a style="font-size: 300%" href="{{url('waiters')}}"--}}
                        {{--class="btn btn-block btn-success btn-lg">Table 3</a>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<br>--}}
                        {{--<div class="row">--}}
                        {{--<div class="col-md-4">--}}
                        {{--<a style="font-size: 300%" href="{{url('waiters')}}"--}}
                        {{--class="btn btn-block btn-success btn-lg">Table 1</a>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-4">--}}
                        {{--<a style="font-size: 300%" href="{{url('waiters')}}"--}}
                        {{--class="btn btn-block btn-success btn-lg">Table 2</a>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-4">--}}
                        {{--<a style="font-size: 300%" href="{{url('waiters')}}"--}}
                        {{--class="btn btn-block btn-success btn-lg">Table 3</a>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

