@extends('kasir')

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
                            <div class="col-md-3" >
                            </div>
                            <div class="col-md-6">
                            <a style="font-size: 300%" href="{{url('areakasir')}}"
                            class="btn btn-block btn-success btn-lg">Dine In</a>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3" >
                            </div>
                            <div class="col-md-6">
                                <a style="font-size: 300%" href="{{url('take')}}"
                                   class="btn btn-block btn-success btn-lg">Take Away</a>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3" >
                            </div>
                            <div class="col-md-6">
                                <a style="font-size: 300%" href="{{url('deliv')}}"
                                   class="btn btn-block btn-success btn-lg">Delivery</a>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

