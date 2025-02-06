<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class PhotoEditor extends Component
{
    use WithFileUploads;

    public $photo;
    public $nom;
    public $prenom;
    public $finalImage;

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:1024', // Max 1MB
        ]);
    }

    public function saveImage($imageData)
    {
        $image = str_replace('data:image/png;base64,', '', $imageData);
        $image = base64_decode($image);
        $path = 'photos/' . uniqid() . '.png';
        Storage::put('public/' . $path, $image);

        $this->finalImage = asset('storage/' . $path);
    }

    public function render()
    {
        return view('livewire.photo-editor')->layout('layouts.master');
    }

    


}
