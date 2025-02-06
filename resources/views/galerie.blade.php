@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="mb-3">Galerie des photos</h2>
    <div class="row">
        @foreach ($images as $image)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <!-- Lien avec data-fancybox pour activer le slider -->
                    <a href="{{ asset($image->path) }}" data-fancybox="gallery" data-caption="Image">
                        <img src="{{ asset($image->path) }}" class="card-img-top" alt="Image">
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Afficher la pagination Bootstrap -->
    <div class="d-flex justify-content-center mt-4">
        {{ $images->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Activer Fancybox avec options pour le slider -->
<script>
    Fancybox.bind("[data-fancybox='gallery']", {
        Thumbs: {
            autoStart: true, // Active les miniatures sous la lightbox
        },
        Toolbar: {
            display: ['zoom', 'fullscreen', 'close'] // Boutons à afficher
        },
        // Options pour activer la navigation
        Keyboard: {
            Next: ['ArrowRight', 'ArrowDown'], // Flèches pour passer à l'image suivante
            Prev: ['ArrowLeft', 'ArrowUp'], // Flèches pour revenir à l'image précédente
        }
    });
</script>
@endsection
