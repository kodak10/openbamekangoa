<?php
namespace App\Http\Controllers;

use App\Models\ImageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function showGallery()
    {
        // Récupérer toutes les images stockées dans la base de données
        $images = ImageModel::all();
        return view('galerie', compact('images'));
    }



    public function saveImage(Request $request)
    {
        try {
            // Vérifier si l'image en base64 est fournie
            $imageData = $request->input('image');
            if (!$imageData) {
                return response()->json(['error' => 'Aucune image fournie'], 400);
            }
    
            // Supprimer le préfixe "data:image/png;base64," et décoder l'image
            $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
            $imageData = base64_decode($imageData);
    
            if (!$imageData) {
                return response()->json(['error' => 'Format d\'image invalide'], 400);
            }
    
            // Créer une image à partir des données décodées
            $image = imagecreatefromstring($imageData);
            if (!$image) {
                return response()->json(['error' => 'Impossible de créer l\'image'], 400);
            }
    
            // Générer un nom unique pour l'image
            $imageName = 'image_' . time() . '.webp';
    
            // Définir le chemin de stockage
            $imagePath = 'images/' . $imageName;
    
            // Convertir et enregistrer l'image en WebP
            $success = imagewebp($image, storage_path('app/public/' . $imagePath));
    
            // Libérer la mémoire
            imagedestroy($image);
    
            if (!$success) {
                return response()->json(['error' => 'Erreur lors de la conversion de l\'image en WebP'], 500);
            }
    
            // Sauvegarder le chemin dans la base de données
            $imageModel = new ImageModel();
            $imageModel->path = 'storage/' . $imagePath; // Chemin accessible publiquement
            $imageModel->save();
    
            // Retourner la réponse avec l'URL publique de l'image
            return response()->json(['success' => true, 'path' => asset('storage/' . $imagePath)]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de l\'enregistrement de l\'image: ' . $e->getMessage()], 500);
        }
    }
       
    
}
