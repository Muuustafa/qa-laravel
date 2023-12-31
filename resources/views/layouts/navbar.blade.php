<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{url('/')}}"><img src="{{asset('images/qa.webp')}}" alt="" style="width: 110px; height:55px;"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="navbar-brand" aria-current="page" href="{{url('/')}}">Accueil</a>
                </li>
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Collectives
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{route('collectives.index')}}">Mes collectives</a></li>
                            <li><a class="dropdown-item" href="{{route('collectives.create')}}">Créer collective</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Questions
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{route('questions.index')}}">Mes questions</a></li>
                            <li><a class="dropdown-item" href="{{route('questions.create')}}">créer question</a></li>
                        </ul>
                    </li>
                @endauth
                <li class="nav-item dropdown">
                    @guest
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Mon Compte
                    </a>
                    @endguest
                    @auth
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    @endauth

                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @guest
                            <li><a class="dropdown-item" href="{{route('login')}}">Se connecter</a></li>
                            <li><a class="dropdown-item" href="{{route('register')}}">S'inscrire</a></li>
                        @endguest
                        @auth
                                <li>
                                    <form id="logoutForm" action="{{route('logout')}}" method="post">
                                        @csrf
                                    </form>
                                    <a class="dropdown-item" href="#"
                                       onclick="document.getElementById('logoutForm').submit()">Deconnexion</a>
                                </li>
                        @endauth
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
