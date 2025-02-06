<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Application Image</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
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
            height: 50vh; /* Hauteur relative à la hauteur de la vue */
            border: 1px solid #ccc;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffff; /* Fond blanc derrière l'image principale */
        }
        .image-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain; /* Conserve les proportions de l'image */
            position: absolute;
        }
        /* Définir la police personnalisée avec @font-face */
        @font-face {
    font-family: 'Birthstone-Regular';
    src: url('/fonts/Birthstone-Regular.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
}

.overlay-text {
    position: absolute;
    color: white;
    background: rgba(3, 71, 148, 0.849); /* Le bleu #034694 avec 50% de transparence */
    padding: 5px;
    border-radius: 5px;
    font-size: 28px;
    font-family: 'Birthstone-Regular'; /* Retirer la virgule après la police */
}

        #text-open {
            background: #034694 !important;
        }
        .controls {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
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
            if (data.success) {
                alert('Image enregistrée avec succès !');
            } else {
                alert('Une erreur est survenue lors de l\'enregistrement de l\'image.');
            }
        })
        .catch(error => {
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
</body>
</html>