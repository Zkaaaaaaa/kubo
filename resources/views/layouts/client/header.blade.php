<nav class="navbar navbar-expand-lg navbar-light bg-light container">
    <a class="navbar-brand" href="{{ route('home') }}">
        <img class="img img-fluid" width="50px" src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt=""> Kubo Kopi
    </a>
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

        <!-- After login: Profile and Logout Dropdown -->
        @auth
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle" width="30" alt="User Image">
                    {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="fas fa-user"></i> Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
        @endauth
    </div>
</nav>
