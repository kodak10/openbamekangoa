<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageModel extends Model
{

    // Spécifiez les champs que vous voulez remplir via un insert (en masse)
    protected $fillable = [
        'path', // Le chemin de l'image
    ];
}
