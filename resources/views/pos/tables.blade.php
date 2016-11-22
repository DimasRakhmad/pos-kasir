@extends('kasir')

@section('htmlheader_title')

@endsection

@section('contentheader_title')
    {{--{{ session('level') }}--}}
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
                                @if ($item->status  == 'Terisi')

                                    <div class="col-md-3" style="padding:10px;">
                                        <a style="font-size: 200%" href="{{url('poskasir',$item->id)}}"
                                           class="btn btn-block btn-danger btn-lg">{{ $item->name }}</a>
                                    </div>

                                @else
                                    <div class="col-md-3" style="padding:10px;">
                                        <a style="font-size: 200%" href="{{url('poskasir',$item->id)}}"
                                           class="btn btn-block btn-success btn-lg">{{ $item->name }}</a>
                                    </div>
                                @endif
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

