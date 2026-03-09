<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    /**
     * Upload d'image pour CKEditor
     */
    public function image(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            
            // Valider le fichier
            $request->validate([
                'upload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
            
            // Générer un nom unique
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            // Stocker l'image
            $path = $file->storeAs('uploads/contents', $filename, 'public');
            
            // Générer l'URL complète
            $url = asset('storage/' . $path);
            
            // Retourner la réponse attendue par CKEditor
            return response()->json([
                'url' => $url,
                'uploaded' => true,
                'fileName' => $filename
            ]);
        }
        
        return response()->json(['error' => 'Aucun fichier uploadé'], 400);
    }
}