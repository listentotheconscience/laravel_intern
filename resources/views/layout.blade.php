<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset('/css/dropdown.css') }}" rel="stylesheet">
    @yield('head')
    <title>{{ $title }}</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">Diary</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav"  aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main_nav">
            <ul class="navbar-nav">
                <li class="nav-item dropdown" id="myDropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="navbarDarkDropdownMenuLink">Menu</a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li> <a class="dropdown-item" href="#" aria-labelledby="navbarDarkDropdownMenuLink">Author &#9660;</a>
                            <ul class="submenu dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item" href="{{ route('author.all') }}">All Authors</a></li>
                                <li><a class="dropdown-item" href="{{ route('author.create.view') }}">New Author</a></li>
                            </ul>
                        </li>
                        <li> <a class="dropdown-item" id="navbarDarkDropdownMenuLink" href="#">Posts &#9660;</a>
                            <ul class="submenu dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item" href="{{ route('post.all') }}">All Posts</a></li>
                                <li><a class="dropdown-item" href="{{ route('post.create.view') }}">New Post</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        @if(Auth::guest())
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="{{ route('auth.login.view') }}">
                        <button type="button" class="btn btn-dark navbar-btn">Log In</button>
                    </a>
                </li>
                <li>
                    <a href="{{ route('auth.signin.view') }}">
                        <button type="button" class="btn btn-dark navbar-btn">Sign In</button>
                    </a>
                </li>
            </ul>
        @else
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="{{ route('user.profile.view') }}">
                        <button type="button" class="btn btn-dark navbar-btn">My Profile</button>
                    </a>
                </li>
                <li>
                    <a href="{{ route('auth.logout') }}">
                        <button type="button" class="btn btn-dark navbar-btn">Log Out</button>
                    </a>
                </li>
            </ul>
        @endif
        <!-- navbar-collapse.// -->
    </div>
    <!-- container-fluid.// -->
</nav>
@yield('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="{{ asset('/js/dropdown.js') }}"></script>
</body>
</html>
