<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optionnel : FontAwesome pour les icônes -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Style personnalisé si nécessaire -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div id="app">
        <!-- Barre de navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">Accueil</a>
                        </li>
                        
                        <!-- Si l'utilisateur est connecté -->
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="">Se déconnecter</a>
                            </li>
                        @endauth
                        <!-- Si l'utilisateur n'est pas connecté -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="">Se connecter</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="">S'inscrire</a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Contenu principal -->
        <main class="py-4">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-light py-4">
            <div class="container text-center">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }} - Tous droits réservés.</p>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS et dépendances -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Optionnel : jQuery si besoin -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Script personnalisé si nécessaire -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
