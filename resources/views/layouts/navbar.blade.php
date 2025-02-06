<!-- resources/views/navbar.blade.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Ma Galerie</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="{{ route('home') }}">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('gallery') }}">Galerie</a>
        </li>
        
      </ul>
    </div>
  </nav>
  