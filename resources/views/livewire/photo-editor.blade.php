<div class="container mt-4">
    <!-- Zone d'édition de l'image -->
    <div id="imageEditor" class="position-relative" style="width: 100%; height: 400px;">
        <!-- Image de fond (par défaut ou image téléchargée) -->
        <img id="uploadedImage" src="{{ $photo ?? asset('background.jpg') }}" class="img-fluid" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: move;">

        <!-- Carte "Open Bamekanoa" -->
        <div class="card position-absolute" style="top: 10%; left: 50%; transform: translateX(-50%); width: 18rem; z-index: 10;">
            <img src="{{ $photo ?? asset('background.jpg') }}" class="card-img-top" alt="Open Bamekanoa">
            <div class="card-body">
            </div>
        </div>

        <!-- Carte "J'y serai" -->
        <div class="card position-absolute" style="bottom: 10%; left: 50%; transform: translateX(-50%); width: 18rem; z-index: 10;">
            <img src="{{ $photo ?? asset('bacground.jpg') }}" class="card-img-top" alt="J'y serai">
            <div class="card-body">
{{--                         <button class="btn btn-primary">J'y serai</button>
 --}}
            </div>
        </div>
    </div>

    <!-- Formulaire pour télécharger l'image -->
    <div class="mt-3">
        <input type="file" wire:model="photo" id="photoInput" class="form-control mb-2" onchange="previewImage(event)">
        <input type="text" wire:model="nom" class="form-control mb-2" placeholder="Nom">
        <input type="text" wire:model="prenom" class="form-control mb-2" placeholder="Prénom">
    </div>

    <!-- Boutons de direction pour déplacer l'image -->
    <div class="mt-2">
        <button onclick="moveImage('up')" class="btn btn-secondary">↑</button>
        <button onclick="moveImage('down')" class="btn btn-secondary">↓</button>
        <button onclick="moveImage('left')" class="btn btn-secondary">←</button>
        <button onclick="moveImage('right')" class="btn btn-secondary">→</button>
        <button wire:click="saveImage()" class="btn btn-primary">Enregistrer</button>
    </div>

    <!-- Affichage de l'image finale -->
    @if($finalImage)
        <div class="mt-4">
            <img src="{{ $finalImage }}" class="img-fluid">
        </div>
    @endif
</div>

@push('scripts')
    <script>
        // Fonction de prévisualisation de l'image téléchargée
        function previewImage(event) {
            let reader = new FileReader();
            reader.onload = function () {
                let uploadedImage = document.getElementById('uploadedImage');
                uploadedImage.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        // Fonction pour déplacer l'image
        function moveImage(direction) {
            let image = document.getElementById('uploadedImage');
            let step = 10;
            let rect = image.getBoundingClientRect();
            switch (direction) {
                case 'up': image.style.top = (rect.top - step) + 'px'; break;
                case 'down': image.style.top = (rect.top + step) + 'px'; break;
                case 'left': image.style.left = (rect.left - step) + 'px'; break;
                case 'right': image.style.left = (rect.left + step) + 'px'; break;
            }
        }
    </script>
@endpush
