<!-- Navbar start -->
<div class="container-fluid">
    <div class="container px-0">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
            <a href="index.html" class="navbar-brand">
                <h1 class="text-primary display-6">Puzzle</h1>
            </a>
            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>
            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="/" class="nav-item nav-link active">Home</a>
                    <a href="{{ route('game.leaderBoard') }}" class="nav-item nav-link">Leadership Board</a>
                    @if (Auth::user())
                        <a href="{{ route('signout') }}" class="nav-item nav-link">Sign out</a>
                    @else
                        <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
                    @endif

                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->
