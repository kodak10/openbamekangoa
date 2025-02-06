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


    public function saveImage(Request $request)
    {
        try {
            // Récupérer l'image en base64 depuis la requête
            $imageData = $request->input('image');
            if (!$imageData) {
                return response()->json(['error' => 'Aucune image fournie'], 400);
            }

            // Extraire la partie base64 de l'image
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = base64_decode($imageData);

            // Générer un nom unique pour l'image
            $imageName = 'image_' . time() . '.png';

            // Sauvegarder l'image dans le répertoire public
            $path = 'public/images/' . $imageName;
            Storage::put($path, $imageData);


            // Sauvegarder le chemin de l'image dans la base de données
            $image = new ImageModel();
            $image->path = Storage::url($path);
            $image->save();

            // Retourner le chemin de l'image
            //return view('welcome');
            return response()->json(['success' => true, 'path' => Storage::url($path)]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de l\'enregistrement de l\'image: ' . $e->getMessage()], 500);
        }
    }


    
    
    // public function upload(Request $request)
    // {
    //     $request->validate([
    //         'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);

    //     if ($request->hasFile('image')) {
    //         $image = $request->file('image');
    //         $imageName = time() . '.' . $image->getClientOriginalExtension();
    //         $image->move(public_path('uploads'), $imageName);

    //         return response()->json(['image_url' => asset('uploads/' . $imageName)]);
    //     }

    //     return response()->json(['error' => 'Image upload failed'], 400);
    // }
}
