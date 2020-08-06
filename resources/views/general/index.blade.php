@extends('layouts.master')

@section('content')
    <div class="container slideBottom">
        <div class="row align-items-center bg-animated border border-info rounded">
            <div class="col-lg-6 order-lg-1">
                <div class="p-5 text-center text-md-left">
                    <h2 class="display-4 pb-3">Welcome!</h2>
                    <p class="lead">The Currency Reference is an easy-to-use web application for 
                    generating graphs to compare the evolution of exchange rates of physical and/or cryptocurrencies.</p>
                </div>
            </div>

            <div class="col-lg-4 order-lg-1 p-4 text-secondary w-50 m-auto mw-md-100">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chart-line" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-chart-line fa-w-16 fa-5x"><path fill="currentColor" d="M496 384H64V80c0-8.84-7.16-16-16-16H16C7.16 64 0 71.16 0 80v336c0 17.67 14.33 32 32 32h464c8.84 0 16-7.16 16-16v-32c0-8.84-7.16-16-16-16zM464 96H345.94c-21.38 0-32.09 25.85-16.97 40.97l32.4 32.4L288 242.75l-73.37-73.37c-12.5-12.5-32.76-12.5-45.25 0l-68.69 68.69c-6.25 6.25-6.25 16.38 0 22.63l22.62 22.62c6.25 6.25 16.38 6.25 22.63 0L192 237.25l73.37 73.37c12.5 12.5 32.76 12.5 45.25 0l96-96 32.4 32.4c15.12 15.12 40.97 4.41 40.97-16.97V112c.01-8.84-7.15-16-15.99-16z" class=""></path></svg>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-lg-3 order-lg-1 p-5 w-50 m-auto mw-md-100 d-none d-md-inline">
                <button type="button" class="btn btn-link btn-block p-3" onclick="location.href='{{ route('rates.calculate') }}'">
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="euro-sign" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-euro-sign fa-w-10 fa-5x"><path fill="currentColor" d="M310.706 413.765c-1.314-6.63-7.835-10.872-14.424-9.369-10.692 2.439-27.422 5.413-45.426 5.413-56.763 0-101.929-34.79-121.461-85.449h113.689a12 12 0 0 0 11.708-9.369l6.373-28.36c1.686-7.502-4.019-14.631-11.708-14.631H115.22c-1.21-14.328-1.414-28.287.137-42.245H261.95a12 12 0 0 0 11.723-9.434l6.512-29.755c1.638-7.484-4.061-14.566-11.723-14.566H130.184c20.633-44.991 62.69-75.03 117.619-75.03 14.486 0 28.564 2.25 37.851 4.145 6.216 1.268 12.347-2.498 14.002-8.623l11.991-44.368c1.822-6.741-2.465-13.616-9.326-14.917C290.217 34.912 270.71 32 249.635 32 152.451 32 74.03 92.252 45.075 176H12c-6.627 0-12 5.373-12 12v29.755c0 6.627 5.373 12 12 12h21.569c-1.009 13.607-1.181 29.287-.181 42.245H12c-6.627 0-12 5.373-12 12v28.36c0 6.627 5.373 12 12 12h30.114C67.139 414.692 145.264 480 249.635 480c26.301 0 48.562-4.544 61.101-7.788 6.167-1.595 10.027-7.708 8.788-13.957l-8.818-44.49z" class=""></path></svg>
                    <p class="font-weight-light">(physical)</p>
                </button>
            </div>

            <div class="col-lg-6 order-lg-1">
                <div class="p-5 text-center">
                    <h2 class="display-4 text-info pb-3">Choose a path..</h2>
                    <p class="lead">Query current and historical financial data provided by the European 
                    Central Bank (ECB) regarding physical currencies along with cryptocurrencies, courtesy of Alpha Vantage.</p>
                </div>
            </div>

            <div class="col-lg-3 order-lg-1 p-5 w-50 m-auto mw-md-100 d-inline d-md-none">
                <button type="button" class="btn btn-link btn-block p-3" onclick="location.href='{{ route('rates.calculate') }}'">
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="euro-sign" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-euro-sign fa-w-10 fa-5x"><path fill="currentColor" d="M310.706 413.765c-1.314-6.63-7.835-10.872-14.424-9.369-10.692 2.439-27.422 5.413-45.426 5.413-56.763 0-101.929-34.79-121.461-85.449h113.689a12 12 0 0 0 11.708-9.369l6.373-28.36c1.686-7.502-4.019-14.631-11.708-14.631H115.22c-1.21-14.328-1.414-28.287.137-42.245H261.95a12 12 0 0 0 11.723-9.434l6.512-29.755c1.638-7.484-4.061-14.566-11.723-14.566H130.184c20.633-44.991 62.69-75.03 117.619-75.03 14.486 0 28.564 2.25 37.851 4.145 6.216 1.268 12.347-2.498 14.002-8.623l11.991-44.368c1.822-6.741-2.465-13.616-9.326-14.917C290.217 34.912 270.71 32 249.635 32 152.451 32 74.03 92.252 45.075 176H12c-6.627 0-12 5.373-12 12v29.755c0 6.627 5.373 12 12 12h21.569c-1.009 13.607-1.181 29.287-.181 42.245H12c-6.627 0-12 5.373-12 12v28.36c0 6.627 5.373 12 12 12h30.114C67.139 414.692 145.264 480 249.635 480c26.301 0 48.562-4.544 61.101-7.788 6.167-1.595 10.027-7.708 8.788-13.957l-8.818-44.49z" class=""></path></svg>
                    <p class="font-weight-light pt-1">(physical)</p>
                </button>
            </div>

            <div class="col-lg-3 order-lg-1 p-5 w-50 m-auto mw-md-100">
                <button type="button" class="btn btn-link btn-block" onclick="location.href='{{ route('crypto.calculate') }}'">
                    <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="btc" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="svg-inline--fa fa-btc fa-w-12 fa-5x"><path fill="currentColor" d="M310.204 242.638c27.73-14.18 45.377-39.39 41.28-81.3-5.358-57.351-52.458-76.573-114.85-81.929V0h-48.528v77.203c-12.605 0-25.525.315-38.444.63V0h-48.528v79.409c-17.842.539-38.622.276-97.37 0v51.678c38.314-.678 58.417-3.14 63.023 21.427v217.429c-2.925 19.492-18.524 16.685-53.255 16.071L3.765 443.68c88.481 0 97.37.315 97.37.315V512h48.528v-67.06c13.234.315 26.154.315 38.444.315V512h48.528v-68.005c81.299-4.412 135.647-24.894 142.895-101.467 5.671-61.446-23.32-88.862-69.326-99.89zM150.608 134.553c27.415 0 113.126-8.507 113.126 48.528 0 54.515-85.71 48.212-113.126 48.212v-96.74zm0 251.776V279.821c32.772 0 133.127-9.138 133.127 53.255-.001 60.186-100.355 53.253-133.127 53.253z" class=""></path></svg>
                    <p class="font-weight-light pt-3">(crypto)</p>
                </button>
            </div>
        </div>
    </div>
@endsection