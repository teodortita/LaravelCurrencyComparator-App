@extends('layouts.master')

@section('content')
        <div class="row slideBottom">
            <div class="col-md-6 offset-md-3">
                <h1 class="text-center font-weight-light">
                    Exchange Rates Overview
                    <hr>
                    <h4 class="text-center font-weight-light font-italic">(click to eliminate)</h4>
                </h1>
            </div>
            <div class="d-none d-md-inline col-md-1 offset-md-1 mt-2">
                {!! QrCode::size(100)->generate($qrUrl) !!}
            </div>
        </div>
        <div class="row slideBottom">
            <div class="col-md-4 my-3">
                <div class="card rounded bg-light border-dark">
                    <div class="card-body py-3 px-3">
                        {!! $barChart->container() !!}
                    </div>
                </div>
            </div>
            <div class="jumbotron m-3 m-md-auto col-md-4 my-3 border">
                <h5>'The Bar Chart' | 'The Radar Chart'</h5>
                <p class="lead">
                    &bull; first: categorical data with bars of heights proportional to its values.
                    <br>
                    &bull; second: multivariate data in the form of quantitative variables.
                </p>
                <hr>
                <h4>(difference in {{$endYear}} vs. {{$startYear}})
                    <br><br>
                    {{$param2}} &rarr; {{$endYearParam2 - $startYearParam2}}
                    <br>
                    {{$param3}} &rarr; {{$endYearParam3 - $startYearParam3}}
                </h4>
            </div>
            <div class="col-md-4 my-3">
                <div class="card rounded bg-light border-dark">
                    <div class="card-body py-3 px-3">
                        {!! $radarChart->container() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row slideBottom">
            <div class="jumbotron m-3 m-md-auto col-md-6 my-2 border">
                <h4>'The Pie Chart:'</h4>
                <p class="lead">This is the graph in which a circle is divided into sectors, each representing 
                    a proportion of the whole.</p>
                <hr><br>
                <h3>(exchange in {{$endYear}})
                    <br><br>
                    1 {{$param1}} =  {{$endYearParam3}} {{$param3}} / {{$endYearParam2}} {{$param2}}
                </h3>
            </div>
            <div class="col-md-6 my-2">
                <div class="card rounded bg-light border-dark">
                    <div class="card-body py-3 px-3">
                        {!! $pieChart->container() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row slideBottom">
            <div class="jumbotron m-3 m-md-auto col-md-4 my-3 border">
                <h5>'The Line Chart:'</h5>
                <p class="lead">This is the curve chart that displays information as a series of data points 
                    connected by line segments.</p>
                <hr><br>
                <h4>(average from {{$startYear}} to {{$endYear}})
                    <br><br>
                    {{$param2}} - {{$averageParam2}}
                    <br>
                    {{$param3}} - {{$averageParam3}}
                </h4>
            </div>
            <div class="col-md-8 my-2">
                <div class="card rounded bg-light border-dark">
                    <div class="card-body py-3 px-3">
                        {!! $lineChartInterval->container() !!}
                    </div>
                </div>
            </div>
        </div>
@endsection