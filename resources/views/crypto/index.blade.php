@extends('layouts.master')

@section('content')
    <div class="row slideBottom">
        <div class="col-md-2 mb-3 mb-md-0 align-self-center">
            <a href="{{$downloadUrl}}" class="btn btn-block btn-lg btn-primary">
                <i class="fas fa-download"></i> Full History .CSV Report
            </a>
        </div>
        <div class="col-md-6 offset-md-1">
            <h1 class="text-center font-weight-light">
                Crypto Markets Overview
                <hr>
                <h4 class="text-center font-weight-light font-italic">(click to eliminate)</h4>
            </h1>
        </div>
        <div class="d-none d-md-inline col-md-1 offset-md-1 mt-2">
            {!! QrCode::size(100)->generate($qrUrl) !!}
        </div>
    </div>
    <div class="row slideBottom">
        <div class="jumbotron m-3 m-md-auto col-md-3 my-3 border">
            <h5>'The OHLC Chart:'</h5>
            <p class="lead">This is the chart used to illustrate movements in the price of a 
                financial instrument over time.</p>
            <hr>
            <h5>&bull; 12 months avg.
                <br><br>
                {{number_format($averageFirstParam)}}/{{number_format($averageSecondParam)}} USD (O/H)
                <br>
                {{number_format($averageThirdParam)}}/{{number_format($averageFourthParam)}} USD (L/C)
            </h5>
        </div>
        <div class="col-md-9 my-3">
            <div class="card rounded bg-light border-dark">
                <div class="card-body py-3 px-3">
                    {!! $lineChartRange->container() !!}
                </div>
            </div>
        </div>
        <div class="jumbotron m-3 m-md-auto col-md-3 my-3 border">
            <h5>'The Bar Chart:'</h5>
            <p class="lead">This is the graph that displays categorical data with bars of heights proportional 
                to its values.</p>
            <hr><br>
            <h4>&bull; 12 months avg.
                <br><br>
                {{number_format($averageParam)}} USD
            </h4>
        </div>
        <div class="col-md-9 my-3">
            <div class="card rounded bg-light border-dark">
                <div class="card-body py-3 px-3">
                    {!! $barChartVolume->container() !!}
                </div>
            </div>
        </div>
    </div>
@endsection