<nav class="navbar navbar-expand-lg navbar-light bg-light container">
    <a class="navbar-brand" href="{{ route('home') }}"><img class="img img-fluid" width="50px"
            src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt=""> Kubo Kopi</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                    aria-expanded="false">
                    Kategori
                </a>
                <div class="dropdown-menu">
                    @foreach ($categories as $category) 
                    <a class="dropdown-item" href="{{ route('category', $category->id) }}">{{ $category->name }}</a>
                    @endforeach
                </div>
            </li>
        </ul>
    </div>
</nav>
