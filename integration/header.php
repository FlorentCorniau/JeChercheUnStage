<nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
    <div class="container"> <!-- container-fluid pour mettre le menu sur toute la largeur -->
        <a class="navbar-brand fw-bold" href="index.php">
            <img src="./img/logo.png" alt="" height="80">
        </a>
        
        <!-- Menu Burger Responsive -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 d-flex justify-align-between">
                <li class="nav-item fs-bold">
                    <a class="nav-link active fw-semibold" aria-current="page" href="index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Stagiaires</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Entreprises</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">FAQ</a>
                </li>
            </ul>
            <!--<form class="d-flex">
                <button class="btn btn-outline-success me-2" type="submit">Connexion</button>
                <button class="btn btn-outline-success" type="submit">Inscription</button>
            </form>-->

            <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <!-- Image d'un User -->
                    
                    <i class="bi bi-person-circle fs-1"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#">Se connecter</a></li>
                    <!--<li>
                        <hr class="dropdown-divider">
                    </li>-->
                    <li><a class="dropdown-item" href="#">S'inscrire</a></li>
                </ul>
            </li>
            </ul>

        </div>
    </div>
</nav>