@extends('layouts.master')
@section('content')



<div id="loading-spinner" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); z-index: 9999; text-align: center;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="spinner-border text-primary" role="status">
        </div>
        <p>Chargement...</p>
    </div>
</div>



<div class="container mt-5">

    <div id="notification" style="display: none; position: fixed; top: 20px; left: 20px; padding: 15px; background-color: #28a745; color: white; border-radius: 5px; z-index: 10000;">
    Image enregistrée avec succès !
</div>
    <div class="row">
        <div class="col-md-8">
            <div class="card w-100" id="capture-area"> 
                <img src="{{ asset('header.jpg') }}" class="img-fluid img-header" alt="Header">
                <div class="image-container">
                    <img id="main-image" src="{{ asset('background.jpg') }}" alt="Image principale">
                    {{-- <div class="overlay-text" id="text-open" style="bottom: 20%; left: 50%; transform: translateX(-50%);">Open Bamakangoa</div> --}}
                    <div class="overlay-text" id="text-here" style="bottom: 10%; left: 50%; transform: translateX(-50%);">J'y serai et toi ?</div>
                </div>
                <img src="{{ asset('footer.png') }}" class="img-fluid img-footer" alt="Footer">
            </div>
        </div>
        <div class="col-md-4">
            <div class="controls">
                <!-- Zone pour l'upload de l'image -->
                <div class="mb-3">
                    <input type="file" id="image-upload" accept="image/*" class="form-control">
                </div>
            
                <!-- Zone des boutons de mouvement (haut, bas, gauche, droite) -->
                <div class="d-flex justify-content-between mb-3">
                    <button onclick="moveImage('up')" class="btn btn-primary">↑</button>
                    <button onclick="moveImage('down')" class="btn btn-primary">↓</button>
                    <button onclick="moveImage('left')" class="btn btn-primary">←</button>
                    <button onclick="moveImage('right')" class="btn btn-primary">→</button>
                </div>
            
                <!-- Zone des boutons de zoom et téléchargement -->
                <div class="d-flex justify-content-between mb-5">
                    <button onclick="zoomIn()" class="btn btn-success">Zoomer</button>
                    <button onclick="zoomOut()" class="btn btn-danger">Dézoomer</button>
                    <button onclick="downloadImage()" class="btn btn-info">Télécharger</button>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Styles communs pour toutes les pages */
    .card {
        background-color: #034694; /* Fond bleu */
        padding: 10px;
        border-radius: 10px;
        overflow: hidden;
    }
    .img-header, .img-footer {
        width: 100%;
        display: block;
    }
    .image-container {
        position: relative;
        width: 100%;
        height: 400px;
        border: 1px solid #ccc;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #ffffff;
    }
    .image-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        position: absolute;
    }
    @font-face {
        font-family: 'Birthstone-Regular';
        src: url('/fonts/Birthstone-Regular.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }
    .overlay-text {
        position: absolute;
        color: white;
        background: rgba(3, 71, 148, 0.849);
        padding: 5px;
        border-radius: 5px;
        font-size: 28px;
        font-family: 'Birthstone-Regular';
    }
    #text-open {
        background: #034694 !important;
    }
</style>
@endpush

@push('scripts')
<script>
    let posX = 0, posY = 0, scale = 1;
    const image = document.getElementById('main-image');

    function moveImage(direction) {
        const step = 10;
        if (direction === 'up') posY -= step;
        if (direction === 'down') posY += step;
        if (direction === 'left') posX -= step;
        if (direction === 'right') posX += step;
        updateTransform();
    }

    function zoomIn() { scale *= 1.1; updateTransform(); }
    function zoomOut() { scale /= 1.1; updateTransform(); }

    function updateTransform() {
        image.style.transform = `translate(${posX}px, ${posY}px) scale(${scale})`;
    }

    // function downloadImage() {
    //     html2canvas(document.getElementById("capture-area")).then(canvas => {
    //         let link = document.createElement('a');
    //         link.href = canvas.toDataURL("image/png");
    //         link.download = 'image-finale.png';
    //         link.click();
    //     });
    // }

    function downloadImage() {
    // Show the loading spinner
    document.getElementById('loading-spinner').style.display = 'block';

    html2canvas(document.getElementById("capture-area")).then(canvas => {
        let base64Image = canvas.toDataURL("image/png");

        fetch('{{ route('save.image') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                image: base64Image,
            }),
        })
        .then(response => response.json())
        .then(data => {
            // Hide the loading spinner after the request is done
            document.getElementById('loading-spinner').style.display = 'none';

            if (data.success) {
                // Afficher la notification de succès
                const notification = document.getElementById('notification');
                notification.style.display = 'block';

                // Masquer la notification après 10 secondes
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 10000);

                // Télécharger l'image
                const link = document.createElement('a');
                link.href = data.path;  // Chemin retourné par le serveur
                link.download = 'image.png'; // Nom du fichier pour le téléchargement
                link.click();  // Déclencher le téléchargement
            } else {
                alert('Une erreur est survenue lors de l\'enregistrement de l\'image.');
            }
        })
        .catch(error => {
            // Hide the loading spinner on error as well
            document.getElementById('loading-spinner').style.display = 'none';
            alert('Erreur : ' + error);
        });
    });
}







    document.getElementById('image-upload').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
                posX = posY = 0;
                scale = 1;
                updateTransform();
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush