<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand font-weight-light font-italic text-uppercase text-info" href="{{ url('/') }}">
            {{ config('app.name', 'The Currency Comparator') }} <i class="fas fa-ellipsis-v"></i>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto mr-5">
                <li class="nav-item">
                    <a class="nav-link mr-2 font-weight-light lead" href="{{ route('rates.calculate') }}">
                        <i class="fas fa-coins"></i> Rates
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mr-2 font-weight-light lead" href="{{ route('crypto.calculate') }}">
                        <i class="fab fa-btc"></i> Markets
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>