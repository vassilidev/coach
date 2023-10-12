<nav class="navbar navbar-marketing navbar-expand-lg bg-transparent navbar-dark bg-dark fixed-top">
    <div class="container-fluid px-10">
        <a class="navbar-brand text-primary fs-1" href="{{route('home')}}">COACH</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation"><i data-feather="menu"></i></button>
        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto me-lg-5">
                <li class="nav-item"><a class="nav-link text-light " href="#coach">Entrainements privés</a></li>
                <li class="nav-item"><a class="nav-link text-light " href="#about-us">A propos</a></li>
                <li class="nav-item"><a class="nav-link text-light " href="#how-it-work">Comment ça marche?</a></li>
                <a class="btn fw-500 ms-lg-4 btn-primary"
                   href="{{route('login')}}">
                    Mon Compte
                    <i class="ms-2" data-feather="arrow-right"></i>
                </a>
            </ul>
        </div>
    </div>
</nav>
