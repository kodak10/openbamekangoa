    let mainImage = document.getElementById('main-image');
    let imageContainer = document.getElementById('image-container');
    let currentZoom = 1;
    let currentX = 0;
    let currentY = 0;

    // Fonction pour déplacer l'image
    function moveImage(direction) {
        switch (direction) {
            case 'up':
                currentY -= 10;
                break;
            case 'down':
                currentY += 10;
                break;
            case 'left':
                currentX -= 10;
                break;
            case 'right':
                currentX += 10;
                break;
        }
        updateImagePosition();
    }

    // Fonction pour zoomer
    function zoomIn() {
        currentZoom += 0.1;
        updateImagePosition();
    }

    // Fonction pour dézoomer
    function zoomOut() {
        if (currentZoom > 0.2) {  // Limite pour éviter de dézoomer trop
            currentZoom -= 0.1;
            updateImagePosition();
        }
    }

    // Met à jour la position et le zoom de l'image
    function updateImagePosition() {
        mainImage.style.transform = `translate(${currentX}px, ${currentY}px) scale(${currentZoom})`;
    }

    // Fonction pour télécharger l'image ajustée
    function downloadImage() {
        // Crée un canevas pour générer l'image téléchargée
        let canvas = document.createElement('canvas');
        let ctx = canvas.getContext('2d');
        // Prend en compte le zoom dans la taille du canevas
        canvas.width = mainImage.naturalWidth * currentZoom;
        canvas.height = mainImage.naturalHeight * currentZoom;

        // Dessine l'image dans le canevas avec la transformation
        ctx.translate(currentX, currentY);
        ctx.scale(currentZoom, currentZoom);
        ctx.drawImage(mainImage, 0, 0);

        // Convertit le canevas en URL de téléchargement
        let dataUrl = canvas.toDataURL('image/png');

        // Crée un lien pour télécharger l'image
        let link = document.createElement('a');
        link.href = dataUrl;
        link.download = 'adjusted-image.png';
        link.click();
    }

    // Fonction pour charger une nouvelle image
    document.getElementById('image-upload').addEventListener('change', function(event) {
        let reader = new FileReader();
        reader.onload = function(e) {
            // Mettre à jour la source de l'image avec le fichier téléchargé
            mainImage.src = e.target.result;
            mainImage.onload = function() {
                // Lorsque l'image est chargée, réinitialiser la position et le zoom
                currentZoom = 1;
                currentX = 0;
                currentY = 0;
                updateImagePosition();
            };
        };
        // Lire le fichier d'image sélectionné
        reader.readAsDataURL(event.target.files[0]);
    });
