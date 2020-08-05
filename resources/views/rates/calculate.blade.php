@extends('layouts.master')

@section('content')
        <div class="row slideBottom">
            <div class="col-md-12">
                <h1 class="text-center font-weight-light">
                    Currency Selection
                </h1>
            </div>
        </div>
        @if(Session::has('info'))
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2 mt-3">
                    <p class="alert alert-warning text-center">{{ Session::get('info') }}</p>
                </div>
            </div>
        @endif
        <div class="row slideBottom">
            <div class="col-12 col-md-8 offset-md-2 mt-3">
                <p class="alert alert-primary text-center">
                    <u>Rules</u>
                    <br>
                    &bull; 2000 &le; Start Year &lt; End Year &lt; {{ now()->year }}
                    <br>
                    &bull; The interval can stretch up to 15 years.
                    <br>
                    <br>
                    <u>Available Currencies</u>
                    <br>
                    &bull; EUR, CAD, HKD, DKK, AUD, SEK, USD, CYP, CHF, SGD, ZAR, GBP, PLN
                </p>
            </div>
        </div>
        <div class="row slideBottom">
            <div class="col-10 offset-1 col-md-6 mt-3 offset-md-3">
                <div class="card rounded bg-light border-dark">
                    <div class="card-header">Input Currencies and Years</div>
                    <div class="card-body">
                        <form action="{{ route('rates.index') }}" method="post">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <div class="form-group text-center">
                                        <label for="param1">Base</label>
                                        <input type="text" class="form-control text-center" id="param1" name="param1"
                                            placeholder="e.g: EUR" value="{{ old('param1') ? old('param1') : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group text-center">
                                        <label for="param2">1st Competitor</label>
                                        <input type="text" class="form-control text-center" id="param2" name="param2"
                                            placeholder="USD" value="{{ old('param2') ? old('param2') : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group text-center">
                                        <label for="param3">2nd Competitor</label>
                                        <input type="text" class="form-control text-center" id="param3" name="param3"
                                            placeholder="GBP" value="{{ old('param3') ? old('param3') : '' }}">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <div class="col-md-4 offset-md-2">
                                    <div class="form-group text-center">
                                        <label for="startYear">Start Year</label>
                                        <input type="text" class="form-control text-center" id="startYear"
                                            name="startYear" placeholder="e.g: 2000" value="{{ old('startYear') ? old('startYear') : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group text-center">
                                        <label for="endYear">End Year</label>
                                        <input type="text" class="form-control text-center" id="endYear" name="endYear"
                                            placeholder="2015" value="{{ old('endYear') ? old('endYear') : '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-2">
                                <div class="col-md-6 offset-md-3">
                                    <button 
                                        type="button" 
                                        class="btn btn-primary btn-block" 
                                        data-toggle="modal"
                                        data-target="#confirmationModal">
                                        Analyze
                                    </button>
                                </div>
                            </div>

                            <div class="modal fade" id="confirmationModal" 
                                tabindex="-1" role="dialog" 
                                aria-labelledby="confirmationModalLabel">
                                <div class="modal-dialog mt-5" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" 
                                                id="confirmationModalLabel">
                                                Confirm
                                            </h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" 
                                                class="btn btn-default" 
                                                data-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                Analyze
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
@endsection